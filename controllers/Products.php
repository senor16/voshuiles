<?php

namespace App\Controllers;

use App\Controller;
use App\Controllers\Errors;
use App\Models\Product;

/**
 * Class Product
 * Use to handle actions about products
 * @package App\Controllers
 */
class Products extends Controller
{

    /********************************************************
     *                                                       *
     *   Functions used to check the validity of fields      *
     *                                                       *
     ******************************************
     *
     *
     * /**
     * Check the validity of the product description
     * Return true if it exists and false if not
     * @param string $description
     * @return bool
     */
    public function checkDescription(string $description): bool
    {
        return ($this->checkText($description) && strlen($description) >= 5);
    }

    /**
     * Function to add a product to the store
     */
    public function ajouter()
    {
        if (!isset($_SESSION['auth'])) {
            $_SESSION['flash']['message'] = "Veuiller vous connecter";
            $_SESSION['flash']['type'] = "error";
            $_SESSION['from']=str_replace('p=','',$_SERVER['QUERY_STRING']);
            header("Location: " . ROOT_URL . "login");
            exit();
        }else{
            if($_SESSION['auth']->role != 'PRODUCTEUR'){
                header("Location: " . ROOT_URL);
            }
        }
        $fields = [];

        $auth = $_SESSION['auth'];
        $title = "Ajouter ";

        $results['error'] = false;
        $results['message'] = [];
        $error = new Errors();
        if (isset($_POST['ajouter'])) {
            $fields = $_POST;


            if (!isset($fields['designation']) || !$this->checkText($fields['designation'])) {
                $results['error'] = true;
                $results['message']['designation'] = $error->showError("Veuillez entrer une valeur valide");
            }
            if (!isset($fields['quality']) || !$this->checkText($fields['quality'])) {
                $results['error'] = true;
                $results['message']['quality'] = $error->showError("Veuillez entrer une valeur valide");
            }

            if (!isset($_FILES['image']) || !$this->checkImage($_FILES['image']['name'])) {
                $results['error'] = true;
                $results['message']['image'] = $error->showError("Veuillez choisir une image au format : 'png','gif','jpg' ou 'jpeg'");
            } else {
                if ($_FILES['image']['error'] != 0) {
                    $results['error'] = true;
                    var_dump($_FILES['image']);
                    $results['message']['image'] = $error->showError("Une erreur s'est produite lors de l'envoi de l'image");
                }

                if ($_FILES['image']['size'] > 2000000) {
                    $results['error'] = true;
                    $results['message']['image'] = $error->showError("Veuiller entrer une image d'au plus 2Mo");
                }


            }


            if (!isset($fields['description']) || !$this->checkDescription($fields['description'])) {
                $results['error'] = true;
                $results['message']['description'] = $error->showError("Veuillez entrer au moins 5 lettres");
            }

            if (!isset($fields['price'])) {
                $results['error'] = true;
                $results['message']['price'] = $error->showError("Entrez un montant valide.");
            }


            if (!isset($fields['quantity']) || $fields['quantity'] < 1) {
                $results['error'] = true;
                $results['message']['quantity'] = $error->showError("Entrez un nombre suppérieur à 0.");
            }


            if (!$results['error']) {
                //Correct the XSS fault
                foreach ($fields as $key => $field) {
                    $fields[$key] = htmlspecialchars($fields[$key]);
                }
                $prod = new Product();
                $fields['owner'] = $auth->id;

                //Upload the image to the server
                $name = $this->str_random(100);
                $fileinfo = pathinfo($_FILES['image']['name']);
                $name = $name . '.' . $fileinfo['extension'];


                if (move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $name)) {
                    $fields['image'] = $name;
                    $id = $prod->add($fields);
                    if ($id) {
                        $results['message']['info'] = "Produit ajouté avec succès";
                        $fields = [];

                    } else {
                        $results['error'] = true;
                        $results['message']['info'] = "Une erreur s'est produite.";
                    }
                } else {
                    $results['error'] = true;
                    $results['message']['info'] = "Une erreur s'est produite.";
                    $results['message']['image'] = $error->showError("Une erreur s'est produite lors de l'envoi du fichier. Veuillez réessayer.");
                }

            } else {
                $results['message']['info'] = "Une erreur s'est produite.";
            }
        }


        $this->render('ajouter', compact('title', 'results', 'fields'));
    }

    /**
     * Update product informations
     */
    public function modifier($id)
    {
        $title = "Modifier";
        $fields = [];
        $results['error'] = false;
        $results['message'] = [];
        $error = new Errors();
        $prod = new Product();
        $product = $prod->getOne($id);
        if ($product && $product->producteur === $_SESSION['auth']->id) {
            if (isset($_POST['modifier'])) {
                $fields = $_POST;
                //Correct the XSS fault
                foreach ($fields as $key => $field) {
                    $fields[$key] = htmlspecialchars($fields[$key]);
                }
                if (isset($fields['quality']) && !$this->checkText($fields['quality'])) {
                    $results['error'] = true;
                    $results['message']['quality'] = $error->showError("Veuillez entrer une valeur valide");
                }

                if (!isset($fields['description']) || !$this->checkDescription($fields['description'])) {
                    $results['error'] = true;
                    $results['message']['description'] = $error->showError("Veuillez entrer au moins 5 lettres");
                }

                if (!isset($fields['price'])) {
                    $results['error'] = true;
                    $results['message']['price'] = $error->showError("Entrez un montant valide.");
                }

                if ($_FILES['image']['size']>0) {

                    if (!$this->checkImage($_FILES['image']['name'])) {
                        $results['error'] = true;
                        $results['message']['image'] = $error->showError("Veuillez choisir une image au format : 'png','gif','jpg' ou 'jpeg'");
                    } else {
                        if ($_FILES['image']['error'] != 0) {
                            $results['error'] = true;
                            $results['message']['image'] = $error->showError("Une erreur s'est produite lors de l'envoi de l'image");
                        }

                        if ($_FILES['image']['size'] > 2000000) {
                            $results['error'] = true;
                            $results['message']['image'] = $error->showError("Veuiller entrer une image d'au plus 2Mo");
                        }


                    }
                }

                if (!$results['error']) {
                    $prod = new Product();
                    //Save the changes
                    $fields['id']=$id;
                    if ($prod->update($fields)) {
                        $results['message']['info'] = "Les modifications ont été enregistrées";
                        $product = $prod->getOne($id);
                    }

                    //Upload the image to the server
                    if ($_FILES['image']['size']>0) {
                        $name = $this->str_random(100);
                        $fileinfo = pathinfo($_FILES['image']['name']);
                        $name = $name . '.' . $fileinfo['extension'];


                        if (move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $name)) {
                            $fields['image'] = $name;
                            $id = $prod->updateImage($name,$id);
                            if ($id) {
                                unlink(ROOT_URL . 'images/' . $product->image);
                                $results['message']['info'] = "Les modifications ont été enregistrées";
                                $product = $prod->getOne($id);
                            } else {
                                $results['error'] = true;
                                $results['message']['info'] = "Une erreur s'est produite.";
                            }
                        } else {
                            $results['error'] = true;
                            $results['message']['info'] = "Une erreur s'est produite.";
                            $results['message']['image'] = $error->showError("Une erreur s'est produite lors de l'envoi du fichier. Veuillez réessayer.");
                        }
                    }
                    $fields = [];
                }else{
                    $results['message']['info'] = "Une erreur s'est produite.";
                }
            }
        } else {

            (new HttpErrors)->notFound();
        }
        $this->render('modifier', compact('title', 'product', 'fields', 'results','id'));
    }

    /**
     * Delete a product
     * @param $id
     */
    public function delete($id)
    {
        $prod = new Product();
        $produit=$prod->getOne($id);
        if($produit && $_SESSION['auth']->id === $produit->producteur){

            if($prod->delete($id)){
                echo '<script>alert("Produit supprimé avec succèss");</script>';
            }else{
                echo '<script>alert("Une erreur s\'est produite");</script>';
            }
            echo '<script>window.location="' . ROOT_URL . 'console";</script>';

        }else{
            (new HttpErrors)->notFound();
        }
    }

    //Search a product
    public function search($q)
    {
        $title = $q . " - Resultat recherche";
        $product = new Product();
        $products = [];
        if (!strlen(trim($q)) < 1) {
            $products = $product->search($q);
        }
        $this->render('search', compact('title', 'products', 'q'));
    }

    public function console(){

        if (!isset($_SESSION['auth'])) {
            $_SESSION['flash']['message'] = "Veuiller vous connecter";
            $_SESSION['flash']['type'] = "error";
            $_SESSION['from']=str_replace('p=','',$_SERVER['QUERY_STRING']);
            header("Location: " . ROOT_URL . "login");
            exit();
        }else{
            if($_SESSION['auth']->role != 'PRODUCTEUR'){
                header("Location: " . ROOT_URL);
                exit();
            }
        }
        $_SESSION['from']=str_replace('p=','',$_SERVER['QUERY_STRING']);
        $owner = $_SESSION['auth'];
        $title="Tableau de bord";
        $prod = new Product();
        $products = $prod->getProductsOf($owner->id);
        $this->render('console',compact('title','products'));
    }

}