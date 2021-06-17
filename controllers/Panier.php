<?php

namespace App\Controllers;

class Panier extends \App\Controller
{

    //Show the content of the cart
    public function index()
    {
        $title = "Panier";
        $this->render('index', compact('title'));
    }

    //Add a product to a cart
    public function add($id)
    {
        if (isset($_POST['add'])) {
            $product = $_POST;
            if (isset($_SESSION['cart'])) {
                $item_array_id = array_column($_SESSION['cart'], 'id');
                if (!in_array($id, $item_array_id)) {
                    $count = count($_SESSION['cart']);
                    $item_array = array(
                        'id' => $id,
                        'designation' => $product['hidden-designation'],
                        'prix' => $product['hidden-prix'],
                        'qualite' => $product['hidden-qualite'],
                        'quantite' => 1
                    );
                    array_push($_SESSION['cart'], $item_array);
                    echo '<script>alert("Le produit a été ajouté dans le panier");</script>';
                } else {
                    echo '<script>alert("Ce produit est déja dans le panier");</script>';
                }
            } else {
                $_SESSION['cart'][0] = array(
                    'id' => $id,
                    'designation' => $product['hidden-designation'],
                    'prix' => $product['hidden-prix'],
                    'qualite' => $product['hidden-qualite'],
                    'quantite' => 1
                );
            }
            echo '<script>window.location="' . ROOT_URL . '";</script>';
        }
    }

    //Modify the quantity of a product
    public function modifyquantity($id, $action)
    {
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $product) {

                if ($product['id'] == $id) {
                    if ($action === 'up') {
                        $_SESSION['cart'][$key]['quantite'] += 1;
                    } elseif ($action === 'down' && $_SESSION['cart'][$key]['quantite'] > 1) {
                        $_SESSION['cart'][$key]['quantite'] -= 1;
                    }
                }
            }
        }
        echo '<script>window.location="' . ROOT_URL . 'panier";</script>';
    }

    //Delete a product from the cart
    public
    function delete($id)
    {
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $product) {
                if ($product['id'] == $id) {
                    unset($_SESSION['cart'][$key]);
                    echo '<script>alert("Le produit a été retiré du panier");</script>';
                }
            }
        }
        echo '<script>window.location="' . ROOT_URL . 'panier";</script>';
    }

    //Confirm and purchase products
    public function confirmer()
    {
        $title = "Confirmer l'achat";
        $fields = [];
        $result = [];
        $result['error'] = false;
        $error = new Errors();
        if (isset($_SESSION['auth'])) {

            if (isset($_POST['payer'])) {
                $fields = $_POST;
                if($fields['mode-paiement']!='visa') {
                    if (isset($fields['tel']) && !$this->checkPhoneNumber($fields['tel'])) {
                        $result['error'] = true;
                        $result['message']['info'] = 'Une erreur s\'est produite';
                        $result['message']['tel'] = $error->showError("Veuiller entrer un numero valide");
                    }
                }else {
                    if ((isset($fields['numero']) && strlen($fields['numero']) < 1) ||
                        (isset($fields['date']) && strlen($fields['date']) < 1) ||
                        (isset($fields['cvc']) && strlen($fields['cvc']) < 1)) {
                        $result['error'] = true;
                        $result['message']['info'] = 'Veuillez remplir tous les champs';
                    }
                }
                if (!$result['error']) {
                    $result['message']['info'] = "Paiement effectu'e avec succèss. Merci pour votre confiance.";
                }
            }

        } else {
            $_SESSION['flash']['message'] = "Veuiller vous connecter";
            $_SESSION['flash']['type'] = "error";
            $_SESSION['from']=str_replace('p=','',$_SERVER['QUERY_STRING']);
            header("Location: " . ROOT_URL . "login");
        }
        $scriptFile = 'confirmer.js';

        $this->render('confirmer', compact('title', 'fields', 'scriptFile', 'result'));
    }

}