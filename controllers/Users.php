<?php

namespace App\Controllers;

use App\Models\User;
use App\Controllers\Errors;

/**
 * Class Client
 * Handle actions about user
 * @package App\Controllers
 */
class Users extends \App\Controller
{


    /**
     * Function which handle user registration
     */
    public function signup()
    {
        $error = new Errors();
        $result['error'] = false;
        $result['message'] = [];
        $user = new User();
        $title = "Inscription";
        if (isset($_POST['tel'])) {
            $fields = $_POST;

            /********************************************************
             *                                                       *
             *   Check if all the required informations was sent     *
             *                                                       *
             ********************************************************/
            // Email
            if (!isset($fields['email']) || !$this->checkEmail($fields['email'])) {
                $result['error'] = true;
                $result['message']['email'] = $error->showError("Veuillez entrer un email valide.");
            }

            //Gender
            if (!isset($fields['gender']) || !$this->checkGender($fields['gender'])) {
                $result['error'] = true;
                $result['message']['gender'] = $error->showError("Veuillez choisir un genre valide");
            }

            //Role
            if (!isset($fields['role']) || !$this->checkRole($fields['role'])) {
                $result['error'] = true;
                $result['message']['role'] = $error->showError("Veuillez effectuer un choix valide");
            }


            //Birth date
            if (!isset($fields['birth_date']) || !$this->checkBirthDate($fields['birth_date'])) {
                $result['error'] = true;
                $result['message']['birth_date'] = $error->showError("Veuillez entrer une date de naissance valide");
            }
            //Password
            if (!isset($fields['password']) || !$this->checkPassword($fields['password'])) {
                $result['error'] = true;
                $result['message']['password'] = $error->showError("Veuillez entrer un mot de passe valide (6 à 255 caractères).");
            }
            //Password confrimation
            if (!isset($fields['password_confirm']) || $fields['password'] !== $fields['password_confirm']) {
                $result['error'] = true;
                $result['message']['password_confirm'] = $error->showError("Les mots de passe ne correspondent pas.");
            }

            /*********************************************************
             *                                                       *
             *   Check the validity of optional Informations         *
             *                                                       *
             ********************************************************/
            //First name
            if (isset($fields['first_name']) && !$this->checkFirstName($fields['first_name'])) {
                $result['error'] = true;
                $result['message']['first_name'] = $error->showError("Veuillez entrer un prénom valide (20 caractères max).");

            }

            //Last name
            if (isset($fields['last_name']) && !$this->checkLastName($fields['last_name'])) {
                $result['error'] = true;
                $result['message']['last_name'] = $error->showError("Veuillez entrer un nom valide (30 caractères max).");

            }

            //Phone number
            if (isset($fields['tel']) && !$this->checkPhoneNumber($fields['tel'])) {
                $result['error'] = true;
                $result['message']['tel'] = $error->showError("Veuillez entrer un numéro valide (9 chiffres).");

            }

            //Town
            if (isset($fields['town']) && !$this->checkTown($fields['town'])) {
                $result['error'] = true;
                $result['message']['town'] = $error->showError("Veuillez entrer une ville valide.");
            }

            //Avatar
            if (isset($fields['avatar']) && !$this->checkImage($fields['avatar'])) {
                $result['error'] = true;
                $result['message']['avatar'] = $error->showError("Veuillez choisir une image valide (format autorisés : .png .jpg .jpeg .gif).");
            }


            //Check if there was an error
            if (!$result['error']) {
                unset($fields['passworf_confirm']);
                //Check if the tel is taken
                $exist = $user->login(['tel' => $fields['tel']]);
                if ($exist) {
                    $result['message']['tel'] = $error->showError("Un compte existe déja avec ce numéro");
                    $result['error'] = true;
                }

                //Check if the email is taken
                $exist = $user->login(['tel' => $fields['email']]);
                if ($exist) {
                    $result['message']['email'] = $error->showError("Un compte existe déja avec cet email");
                    $result['error'] = true;
                }


                if (!$result['error']) {
                    $fields['password'] = password_hash($fields['password'], PASSWORD_BCRYPT);
                    $req = $user->signup($fields);
                    if ($req)
                        $result['message']['info'] = "Inscription réussite";
                    else {
                        $result['error'] = true;
                        $result['message']['info'] = "Une erreur s'est produite. Veuiller réessayer.";
                    }
                }
            } else {
                $result['message']['info'] = "L'opération a échouée.";
            }

            $this->render('signup', compact('title', 'result', 'fields'));

        } else {

            $this->render('signup', compact('title'));
        }
    }


    /**
     * Function used to handle user login
     * he logs in with his email and password
     */
    public function login()
    {
        //Initialise values
        $result['error'] = false;
        $result['message'] = [];
        $title = "Connexion";
        $user = new User();

        //Get the flash message then delete it
        $flash = '';
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

        //Redirect the user to the home page if he is already logged in
        if (isset($_SESSION['auth'])) {
            header('Location: ' . ROOT_URL);
            exit();

        }

        //Check if the user has filled the fields
        if (isset($_POST['tel'])) {
            $fields = $_POST;

            /**
             * Check the validity of the credentials
             */
            //Email
            if (!isset($fields['tel'])) {
                $result['error'] = true;
                $result['message']['email'] = 'Veuillez entrer une adresse email ou un numéro valide';
            }

            //Password
            if (!isset($fields['password'])) {
                $result['error'] = true;
                $result['message']['password'] = 'Veuillez entrer votre mot de passe';
            }

            if (!$result['error']) {
                $auth = $user->login($fields);

                if ($auth) {
                    if (password_verify($fields['password'], $auth->password)) {
                        //Generate remember token
                        if (isset($fields['remember'])) {
                            $fields['remember'] = $this->str_random(250);


                            $_SESSION['auth'] = $auth;

                            setcookie('remember', $auth->id . '-' . $fields['remember'] . sha1($auth->id . 'projetlicence3'), time() + 60 * 60 * 24 * 7);
                        }
                        $result['message'] = 'Connexion réussie.';
                        header('Location: '.ROOT_URL);
                        exit();


                    } else {
                        $result['error'] = true;
                        $result['message'] = "Identifiants incorrects";
                    }
                } else {
                    $result['error'] = true;
                    $result['message'] = "Identifiants incorrects";
                    $result['tel'] = $fields['tel'];
                }
                $this->render('login', compact('title', 'result'));
            }
        } elseif (isset($_COOKIE['remember'])) {
            $token = explode('-', $_COOKIE['remember']);
            $auth = $user->getOne($token[0]);

            if ($token[1] === $auth->remember_token . sha1($token[0] . 'projetlicence3')) {
                $_SESSION['auth'] = $auth;
                setcookie('remember', $token[0] . '-' . $token[1], time() + 60 * 60 * 24 * 7);
                header('Location: '.ROOT_URL);
                exit();
                $result['message'] = 'Connexion réussie.';
                $this->render('login', compact('title', 'result'));
            }
        }else{

                //Show the result in a json
                //$this->showJSon($result);
                $this->render('login', compact('title'));

            }

    }

    /*
    Function to log out the user
*/
    public function logout(){
        setcookie('remember',NULL);
        unset($_SESSION['auth']);
        header('Location: '.ROOT_URL.'login');
        exit();

    }
    public function settings(string $action, array $fields = [])
    {
        $result['error'] = false;
        $result['message'] = [];

        //Perform the right action
        switch ($action) {
            case "profile":

                //Check last name
                if (isset($fields['last_name']) && !$this->checkLastName($fields['last_name'])) {
                    $result['error'] = true;
                    $result['message']['last_name'] = 'Veuillez un nom valide';
                }

                //Check first name
                if (isset($fields['first_name']) && !$this->checkFirstName($fields['first_name'])) {
                    $result['error'] = true;
                    $result['message']['first_name'] = "Veuillez entrer un prénom valide";
                }

                //Check avatar
                if (isset($fields['avatar']) && !$this->checkAvatar($fields['avatar'])) {
                    $result['error'] = true;
                    $result['message']['avatar'] = "Veuillez choisir une image valide (format autorisés : .png .jpg .jpeg .gif).";
                }

                //Check phone number
                if (isset($fields['tel']) && !$this->checkPhoneNumber($fields['tel'])) {
                    $result['error'] = true;
                    $result['message']['tel'] = "Veuillez entrer un numéro valide (9 chiffres).";
                }

                //Check town
                if (isset($fields['town']) && !$this->checkTown($fields['town'])) {
                    $result['error'] = true;
                    $result['message']['town'] = "Veuillez entrer une ville valide.";
                }

                //Check birth date
                if (isset($fields['birth_date']) && !$this->checkBirthDate($fields['birth_date'])) {
                    $result['error'] = true;
                    $result['message']['birth_date'] = "Veuillez entrer une date de naissance valide";
                }

                //Check gender
                if (isset($fields['gender']) && !$this->checkGender($fields['gender'])) {
                    $result['error'] = true;
                    $result['message']['gender'] = "Veuillez choisir un genre valide";
                }

                //Check email
                if (isset($fields['email']) && !$this->checkEmail($fields['email'])) {
                    $result['error'] = true;
                    $result['message']['email'] = "Veuillez entrer un email valide.";
                }

                if (!$result['error']) {
                    $result['info'] = "Les modifications ont été enregistrées avecsuccès.";
                    $result['message']['email'] = "Un email vous a été envoyé pour confirmer votre nouvelle adresse email";
                    $result['message']['tel'] = "Un sms vous a été envoyé pour confirmer votre nouveau numéro de téléphone";
                }

                break;


            case "account":
                if (!isset($fields['password'])) {
                    $result['error'] = true;
                    $result['message']['password'] = "Veuiller entrer votre mot de passe";
                }

                if (!$result['error']) {
                    $result['info'] = "Votre compte a été supprimé";
                }

                break;

            case "password":
                if (!isset($fields['password'])) {
                    $result['error'] = true;
                    $result['message']['password'] = "Veuillez entrer votre mot de passe actuel";
                }

                if (!isset($fields['new_password']) || !$this->checkPassword($fields['new_password'])) {
                    $result['error'] = true;
                    $result['message']['new_password'] = "Veuillez entrer un mot de passe valide (6 à 255 caractères).";
                }

                if (!isset($fields['password_confirm']) || $fields['new_password'] !== $fields['password_confirm']) {
                    $result['error'] = true;
                    $result['message']['password_confirm'] = "Les mots de passes ne correspondent pas";
                }

                if (!$result['error']) {
                    $result['info'] = "Votre mot de passe a été modifié avec succès";
                }

                break;

        }

        //Show the result in a json
        $this->showJSon($result);
    }

    /**
     * Function to test the user actions
     * @param string $action
     */
    public
    function test(string $action)
    {

        switch ($action) {
            case "signup":
                //Required
                $fields['email'] = "hello@th.com";
                $fields['gender'] = "male";
                $fields['birth_date'] = "31-03-2001";
                $fields['password'] = "aqwedede";
                $fields['password_confirm'] = "aqwedede";

                //Optional
                $fields['first_name'] = "John";
                $fields['last_name'] = "Smith";
                $fields['town'] = "Garoua";
                $fields['tel'] = "698142207";
                $fields['avatar'] = "hello-kitty.here.png";
                $this->signup($fields);
                break;
            case "login":
                $fields['email'] = 'hello@hello.com';
                $fields['password'] = 'titi';
                $this->login($fields);
                break;
        }

    }

    /*
     * Test settings
     */
    public
    function tests($action)
    {
        $fields = [];
        switch ($action) {
            case "profile":
                $fields['email'] = "hello@th.com";
                $fields['gender'] = "male";
                $fields['birth_date'] = "31-03-2001";

                $fields['first_name'] = "John";
                $fields['last_name'] = "Smith";
                $fields['town'] = "Garoua";
                $fields['tel'] = "698142207";
                $fields['avatar'] = "hello-kitty.here.png";
                break;

            case "account":
                $fields['password'] = 'kalitori';
                break;

            case "password":
                $fields['password'] = "aqwedede";
                $fields['new_password'] = "aqwede";
                $fields['password_confirm'] = "aqwede";
                break;

        }
        $this->settings($action, $fields);
    }
}