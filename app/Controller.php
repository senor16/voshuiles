<?php
namespace App;

use \DateTime;


abstract class Controller{
    protected array $result;

    //Function used the render pages
    public function render(string $file,array $args=[]){
        //Get the parameters out of their table
        extract($args);

        //Get the dirrectory of the file
        $dir = explode('\\',get_class($this));
        $dir = $dir[count($dir)-1];

        //Load the file
        require_once ROOT.'views/'.$dir.'/'.$file.'.php';

        //Load the default template
        require_once ROOT.'views/layout/default.php';
    }

    //Function to load a script
    public function loadScript(string $file):string{
        return '<script src="'.ROOT_URL.'js/'.strtolower($file).'></script>';
    }

    //Function to load a stylesheet
    public function loadStyle(string $file):string{
        return '<link rel="stylesheet" href="'.ROOT_URL.'css/'.strtolower($file).'>';
    }



    /********************************************************
    *                                                       *
    *   Functions used to check the validity of fields      *
    *                                                       *
    ********************************************************/

    /**
     * Check the validity of the user'avatar
     * Allowed image extensions : .png .gif .jpg .jpeg
     * return true if a last name is valid and false if not
     * @param string $avatar
     * @return bool
     */
    public function checkImage(string $avatar):bool{
        $allowed_extensions =['png','gif','jpg','jpeg'];
        $pathinfo = pathinfo($avatar);
        $extension =$pathinfo['extension'];
        return in_array($extension,$allowed_extensions);
    }

    //Function to show a variable as a json
    public function showJson($var){
        header('Content-Type: application/json');
        echo json_encode($var);
    }

    //Return a string without accents or space
    public function setSlug(string $var):string{
        $search =  ['à','â','é','è','ë','ê','ò','ô','ù','ü','ï','î',' ','ç','À','Â','É','È','Ë','Ê','Ò','Ô','Ù','Ü','Ï','Î',' ','Ç'];
        $replace = ['a','a','e','e','e','e','o','o','u','u','i','i','-','c','A','A','E','E','E','E','O','O','U','U','I','I','-','C'];

        $str = $var;
        for($i=0; $i<count($search); $i++){
            $str = str_replace($search[$i],$replace[$i],$str);
        }
        return $str;
    }


    /**
     * Check the validity of a first name
     * less than 20 characters
     * return true if a first name is valid and false if not
     * @param string $first_name
     * @return bool
     */
    public function checkFirstName(string $first_name):bool{
        return !(empty($first_name) || ! preg_match("/^[a-zA-Zéèïëçêâàôöòó\-]+$/", $first_name) ||
            strlen($first_name) > 20);
    }

    /**
     * Check the validity of a last name
     * less than 70 characters
     * return true if a last name is valid and false if not
     * @param string $last_name
     * @return bool
     */
    public function checkLastName(string $last_name):bool{
        return !(empty($last_name) || !preg_match("/^[a-zA-Zéèïëçàêâôöòó\- ]+$/", $last_name) || strlen($last_name) > 30);
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
        return !(empty($town) || ! preg_match("/^[a-zA-Zéè ïëçàêâôöòó\-]+$/", $town) ||
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
     * Check the validity of a gender ( whether male or female)
     * return true if valid and false if not
     * @param string $gender
     * @return bool
     */
    public function checkGender(string $gender):bool{
        return !(empty($gender) ||  !in_array($gender,['F','M']));
    }

    /**
     * Check the validity of a role (whether to buy or to sell)
     * return true if valid and false if not
     * @param string $role
     * @return bool
     */
    public function checkRole(string $role):bool{
        return !(empty($role) ||  !in_array($role,['CLIENT','PRODUCTEUR']));
    }

    /*
    Generate random caracters token
    args: $length => the length of the token
*/
    public function str_random(int $length){
        $alphabet ="qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM";
        $alphabet = str_repeat($alphabet,$length);
        $alphabet = str_shuffle($alphabet);
        return substr($alphabet,0,$length);
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

    public function checkBirthDate(string $date):bool{
        $dat = explode('-',$date);
        $date = new DateTime($date);
        $today = new DateTime('today');
        $age = $today->diff($date);


        return !(!checkdate((int)$dat[1],(int)$dat[2],(int)$dat[1]) || $age->y <18) ;
    }


}