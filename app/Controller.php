<?php
namespace App;

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



}