<?php
session_start();
use App\Controllers\HttpErrors;



define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));

$url = $_SERVER['SERVER_ADDR'];
define('ROOT_URL','http://'.$url.'/');

require_once ROOT."vendor/autoload.php";

//Get the url parameters
$params = $_GET['p'];


//Store the parameters in a table
$params = explode('/',$params);


//Get the controller
//If not set choose the default controller
$controller = $params[0]!= '' ? ucfirst(strtolower($params[0])):'Home';

//Path of a controller
$file = ROOT.'controllers/'.$controller.'.php';



//Variable used to store whether a 404 error occurred
$error = false;

//Check if the controller exists
if(file_exists($file)){
    //Get the controller object
    $controller = "App\\Controllers\\".$controller;


    //Check if the controller class exists
    if(class_exists($controller)){
        //Instanciate the controller
        $controller = new $controller;

        //Get the action
        //If not set, use the default action
        $action = isset($params[1])?strtolower($params[1]):'index';

        //Check if the action exists
        if(method_exists($controller,$action)){
            //Remove the controller and the action from the parameters table
            unset($params[0]);
            unset($params[1]);

            //Call the action and send the parameters
            call_user_func_array([$controller,$action],$params);
        }else{
            $error = true;
        }

    }else{
        $error = true;
    }

}else{
    $error = true;
}

if($error){
    $error = new HttpErrors();
    $error->notFound();
}