<?php
namespace App;

abstract class Controller{
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

    //Function to show a variable as a json
    public function showJson($var){
        header('Content-Type: application/json');
        echo json_encode($var);
    }
}