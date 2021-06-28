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

        //Redirect the user to the home page if he is already logged in
        if (isset($_SESSION['auth'])) {
            $_SESSION['flash']['message'] = 'Bienvenu ' . $_SESSION['auth']->prenom . '.';
            $_SESSION['flash']['type'] = 'success';
            header('Location: ' . ROOT_URL);
            exit();
        }


        if (isset($_POST['tel'])) {
            $fields = $_POST;
            //Correct the XSS fault
            foreach ($fields as $key => $field) {
                $fields[$key] = htmlspecialchars($fields[$key]);
            }

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
                    if ($req) {
                        $_SESSION['flash']['message'] = "Inscription réussite";
                        $_SESSION['flash']['type'] = 'success';
                        if (isset($_SESSION['from'])) {
                            unset($_SESSION['from']);
                            header('Location: ' . ROOT_URL . $_SESSION['from']);
                        } else {
                            header('Location: ' . ROOT_URL);
                        }
                    } else {
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
            $_SESSION['flash']['message'] = 'Bienvenu ' . $_SESSION['auth']->prenom . '.';
            $_SESSION['flash']['type'] = 'success';
            $this->redirect();
            exit();
        }

        //Check if the user has filled the fields
        if (isset($_POST['tel'])) {
            $fields = $_POST;
            //Correct the XSS fault
            foreach ($fields as $key => $field) {
                $fields[$key] = htmlspecialchars($fields[$key]);
            }

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
                if (isset($fields['remember'])) {
                    $fields['remember_token'] = $this->str_random(250);
                }
                $auth = $user->login($fields);
                if ($auth) {
                    if (password_verify($fields['password'], $auth->password)) {

                        $_SESSION['auth'] = $auth;
                        //Generate remember token
                        if (isset($fields['remember'])) {
                            setcookie('remember_token', $auth->id . '-' . $fields['remember_token'] . sha1($auth->id . 'projetlicence3'), time() + 60 * 60 * 24 * 7);
                        }
                        $_SESSION['flash']['message'] = 'Bienvenu ' . $auth->prenom . '.';
                        $_SESSION['flash']['type'] = 'success';
                        $this->redirect();
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
        } elseif (isset($_COOKIE['remember_token'])) {
            $token = explode('-', $_COOKIE['remember_token']);
            $auth = $user->getOne($token[0]);

            if ($token[1] === $auth->remember . sha1($token[0] . 'projetlicence3')) {
                $_SESSION['auth'] = $auth;

                setcookie('remember', $token[0] . '-' . $token[1], time() + 60 * 60 * 24 * 7);
                $_SESSION['flash']['message'] = 'Bienvenu ' . $auth->prenom . '.';
                $_SESSION['flash']['type'] = 'success';
                $this->redirect();
                exit();
            }
        } else {

            $this->render('login', compact('title', 'flash'));

        }

    }

    /*
    Function to log out the user
*/
    public function logout()
    {
        setcookie('remember_token', NULL);
        unset($_SESSION['auth']);
        unset($_SESSION['flash']);
        header('Location: ' . ROOT_URL . 'login');
        exit();

    }

    public function settings(string $action = "main")
    {
        $title = "Paramètres";
        $error = new Errors();
        //Redirect the user to the login page if he is not logged
        if (!isset($_SESSION['auth'])) {
            $_SESSION['flash']['message'] = "Veuiller vous connecter";
            $_SESSION['flash']['type'] = "error";
            $_SESSION['from'] = str_replace('p=', '', $_SERVER['QUERY_STRING']);
            header("Location: " . ROOT_URL . "login");
        } else {
            $auth = $_SESSION['auth'];
            $title = "Paramètres";
            $result['error'] = false;
            $result['message'] = [];
            $fields = [];
            $user = new User();

            if (isset($_POST['submit'])) {
                $fields = $_POST;
                //Correct the XSS fault
                foreach ($fields as $key => $field) {
                    $fields[$key] = htmlspecialchars($fields[$key]);
                }
                //Perform the right action
                switch ($action) {
                    case "profil":
                        //Check last name
                        if (isset($fields['last_name']) && !$this->checkLastName($fields['last_name'])) {
                            $result['error'] = true;
                            $result['message']['last_name'] = $error->showError('Veuillez un nom valide');
                        }

                        //Check first name
                        if (isset($fields['first_name']) && !$this->checkFirstName($fields['first_name'])) {
                            $result['error'] = true;
                            $result['message']['first_name'] = $error->showError("Veuillez entrer un prénom valide");
                        }


                        //Check phone number
                        if (isset($fields['tel']) && !$this->checkPhoneNumber($fields['tel'])) {
                            $result['error'] = true;
                            $result['message']['tel'] = $error->showError("Veuillez entrer un numéro valide (9 chiffres).");
                        }

                        //Check town
                        if (isset($fields['town']) && !$this->checkTown($fields['town'])) {
                            $result['error'] = true;
                            $result['message']['town'] = $error->showError("Veuillez entrer une ville valide.");
                        }

                        //Check birth date
                        if (isset($fields['birth_date']) && !$this->checkBirthDate($fields['birth_date'])) {
                            $result['error'] = true;
                            $result['message']['birth_date'] = $error->showError("Veuillez entrer une date de naissance valide");
                        }

                        //Check gender
                        if (isset($fields['gender']) && !$this->checkGender($fields['gender'])) {
                            $result['error'] = true;
                            $result['message']['gender'] = $error->showError("Veuillez choisir un genre valide");
                        }

                        //Check email
                        if (isset($fields['email']) && !$this->checkEmail($fields['email'])) {
                            $result['error'] = true;
                            $result['message']['email'] = $error->showError("Veuillez entrer un email valide.");
                        }

                        if (!$result['error']) {
                            if($user->update($fields,$auth->id)){
                                $result['message']['info'] = "Les modifications ont été enregistrées avec succès.";
                                $fields=[];
                                $auth = $user->getOne($auth->id);
                                $_SESSION['auth']=$auth;
                            }else{
                                $result['error']=true;
                                $result['message']['info'] = "Une erreur s'est produite";
                            }

                        }

                        break;

                    case "password":
                        if (!isset($fields['password']) || !password_verify($fields['password'], $auth->password)) {
                            $result['error'] = true;
                            $result['message']['password'] = $error->showError("Veuillez entrer votre mot de passe actuel");
                        }

                        if (!isset($fields['new_password']) || !$this->checkPassword($fields['new_password'])) {
                            $result['error'] = true;
                            $result['message']['new_password'] = $error->showError("Veuillez entrer un mot de passe valide (6 à 255 caractères).");
                        }

                        if (!isset($fields['password_confirm']) || $fields['new_password'] !== $fields['password_confirm']) {
                            $result['error'] = true;
                            $result['message']['password_confirm'] = $error->showError("Les mots de passes ne correspondent pas");
                        }

                        if (!$result['error']) {
                            if($user->updatePassword(password_hash($fields['new_password'], PASSWORD_BCRYPT),$auth->id)){
                                $auth = $user->getOne($auth->id);
                                $_SESSION['auth']=$auth;
                                $result['message']['info'] = "Votre mot de passe a été modifié avec succès";
                            }else{
                                $result['error']=true;
                                $result['message']['info'] = "Une erreur s'est produite";
                            }

                        }

                        break;

                }
            }
        }

        $this->render('settings', compact('title', 'fields', 'action', 'auth', 'result'));
    }

    //Restore user credentials
    public function restore()
    {
        $title = "Réinitialiser le mot de passe";
        $result = [];
        $result['error'] = false;
        $fields = [];
        $error = new Errors();
        $user = new User();
        if (isset($_POST['tel'])) {
            $fields = $_POST;

            if (!$this->checkEmail($fields['tel']) && !$this->checkPhoneNumber($fields['tel'])) {
                $result['error'] = true;

                $result['message']['info'] = "Une erreur s'est produite";
                $result['message']['tel'] = $error->showError("Veuiller entrer un email ou un numéro valide");
            } else {
                $auth = $user->login($fields);
                if ($auth) {
                    $result['message']['info'] = "Nous vous avons envoyé un lien pour restaurer votre mot de passe";
                } else {
                    $result['error'] = true;
                    $result['message']['info'] = "Une erreur s'est produite";
                    $result['message']['tel'] = $error->showError("Il n'existe aucun compte avec cet email/numéro");
                }
            }
        }

        $this->render('restore', compact('title', 'result', 'fields'));
    }

}