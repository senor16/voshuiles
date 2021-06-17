<?php
namespace App\Controllers;
use App\Controller;
use App\Models\Product;

class Home extends Controller{

    //Home page
    public function index(){
        $title="Accueil";
      	$product = new Product();

        //Get the flash message then delete it
        $flash = '';
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

    	$products = $product->getAll();
        $this->render('index',compact('title','products','flash'));
    }
}