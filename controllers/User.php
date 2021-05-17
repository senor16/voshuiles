<?php


namespace App\Controllers;

use DateTime;

class User extends \App\Controller
{

    /********************************************************
    *                                                       *
    *   Functions used to check the validity of fields*     *
    *                                                       *
    ********************************************************/

    /**
     * Check the validity of a first name
     * less than 20 characters
     * return true if a first name is valid and false if not
     * @param string $first_name
     * @return bool
     */
    public function checkFirstName(string $first_name):bool{
        return !(empty($first_name) || ! preg_match("/^[a-zA-Zéèïëçêâôöòó\-]+$/", $first_name) ||
            strlen($first_name) > 20);
    }

    /**
     * Check the validity of a last name
     * less than 70 characters
     * return true if a last name is valid and false if not
     * @param string $last_name
     * @return bool
     */
    public function checkLasstName(string $last_name):bool{
        return !(empty($last_name) || !preg_match("/^[a-zA-Zéèïëçêâôöòó\- ]+$/", $last_name) || strlen($last_name) > 70);
    }

    /**
     * Check the validity of the user'avatar
     * Allowed image extensions : .png .gif .jpg .jpeg
     * return true if a last name is valid and false if not
     * @param string $avatar
     * @return bool
     */
    public function checkAvatar(string $avatar):bool{
        $allowed_extensions =['png','gif','jpg','jpeg'];
        $pathinfo = pathinfo($avatar);
        $extension =$pathinfo['extension'];
        return in_array($extension,$allowed_extensions);
    }

    /**
     * Check the validity of a phone number
     * 9 digits
     * return true if it is valid and false if not
     * @param string $phone_number
     * @return bool
     */
    public function checkPhoneNumber(string $phone_number):bool{
        return !(strlen($phone_number) < 9 || ! preg_match("/^[0-9]+$/", $phone_number) || strlen($phone_number) > 9);
    }

    /**
     * Check the value of the town name
     * return true if valid, false if not
     * @param string $town
     * @return bool
     */
    public function checkTown(string $town):bool{
        return !(empty($town) || ! preg_match("/^[a-zA-Zéèïëçêâôöòó\-]+$/", $town) ||
            strlen($town) > 20);
    }

    /**
     * Check the validity of an email address
     * It return true if an email address is valid and false if not
     * @param string $email
     * @return bool
     */
    public function checkEmail(string $email):bool {
        return !(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    /**
     * Check the validity of a gender (wheter male or female)
     * return true if valid and false if not
     * @param string $gender
     * @return bool
     */
    public function checkGender(string $gender):bool{
        return !(empty($gender) ||  !in_array($gender,['male','female']));
    }

    /**
     * Check the validity of an password (6 to 255 characters)
     * return true if the password is valid and false if not
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password):bool{
        return !(strlen($password) < 6 || strlen($password) > 255);
    }

    public function checkBirthDate(string $date){
        $dat = explode('-',$date);
        $date = new DateTime($date);
        $today = new DateTime('today');
        $age = $today->diff($date);

        return !(!checkdate((int)$dat[1],(int)$dat[0],(int)$dat[2]) || $age->y <18) ;
    }

    /**
     * Function which handle user registration
     * @param array $fields
     */
    public function signup(array $fields=[]){

        $result['error']=false;
        $result['message']=[];

        /********************************************************
        *                                                       *
        *   Check if all the required informations was sent     *
        *                                                       *
        ********************************************************/
        // Email
        if (!isset($fields['email']) || !$this->checkEmail($fields['email'])){
            $result['error']=true;
            $result['message']['email']="Veuillez entrer un email valide.";
        }

        //Gender
        if(!isset($fields['gender']) || !$this->checkGender($fields['gender'])){
            $result['error']=true;
            $result['message']['gender']="Veuillez choisir un genre valide";
        }

        //Birth date
        if(!isset($fields['birth_date']) || !$this->checkBirthDate($fields['birth_date'])){
            $result['error']=true;
            $result['message']['birth_date']="Veuillez entrer une date de naissance valide";
        }
        //Password
        if(!isset($fields['password']) || !$this->checkPassword($fields['password'])){
            $result['error']=true;
            $result['message']['password']="Veuillez entrer un mot de passe valide (6 à 255 caractères).";
        }

        //Password confrimation
        if(!isset($fields['password_confirm']) || $fields['password'] !== $fields['password_confirm']){
            $result['error']=true;
            $result['message']['password_confirm']="Les mots de passe ne correspondent pas.";
        }

        /*********************************************************
        *                                                       *
        *   Check the validity of optional Informations         *
        *                                                       *
        ********************************************************/
        //First name
        if(isset($fields['first_name']) && !$this->checkFirstName($fields['first_name'])){
            $result['error']=true;
            $result['message']['first_name']="Veuillez entrer un prénom valide (20 caractères max).";

        }

        //Last name
        if(isset($fields['last_name']) && !$this->checkLasstName($fields['last_name'])){
            $result['error']=true;
            $result['message']['last_name']="Veuillez entrer un nom valide (70 caractères max).";

        }

        //Phone number
        if(isset($fields['phone_number']) && !$this->checkPhoneNumber($fields['phone_number'])){
            $result['error']=true;
            $result['message']['phone_number']="Veuillez entrer un numéro valide (9 chiffres).";

        }

        //Town
        if(isset($fields['town']) && !$this->checkTown($fields['town'])){
            $result['error']=true;
            $result['message']['town']="Veuillez entrer une ville valide.";
        }

        //Avatar
        if(isset($fields['avatar']) && !$this->checkAvatar($fields['avatar'])){
            $result['error']=true;
            $result['message']['avatar']="Veuillez choisir une image valide (format autorisés : .png .jpg .jpeg .gif).";
        }



        //Check if there was an error
        if(!$result['error']){
            $result['message']['info']="Inscription réussite";
        }

        //Show the result in a json
        header('Content-Type: application/json');
        echo json_encode($result);
    }


    /**
     * Function used to handle user login
     * he logs in with his email and password
     * @param array $fields
     */
	public function login(array $fields=[]){
		$result['error']=false;
		$result['message']=[];
        /**
         * Check the validity of the credentials
         */
        //Email
	    if(!isset($fields['email']) || !$this->checkEmail($fields['email']) ){
		    $result['error']=true;
		    $result['message']['email']='Veuillez entrer une adresse email valide';
        }

	    //Password
        if(!isset($fields['password'])){
            $result['error']=true;
            $result['message']['password']='Veuillez entrer votre mot de passe';
        }

        if(!$result['error']){
            $result['message']='Connexion réussie.';
        }

        //Show the result in a json
        header('Content-Type: application/json');
        echo json_encode($result);
	}
    /**
     * Function to test the user actions
     * @param string $action
     */
    public function test(string $action){

        switch($action){
            case "signup":
                //Required
                $fields['email']="hello@th.com";
                $fields['gender']="male";
                $fields['birth_date']="31-03-2001";
                $fields['password']="aqwedede";
                $fields['password_confirm']="aqwedede";

                //Optional
                $fields['first_name']="John";
                $fields['last_name']="Smith";
                $fields['town']="Garoua";
                $fields['phone_number']="698142207";
                $fields['avatar']="hello-kitty.here.png";
                $this->signup($fields);
                break;
            case "login":
                $fields['email']='hello@hello.com';
                $fields['password']='titi';
                $this->login($fields);
                break;
        }

    }
}
