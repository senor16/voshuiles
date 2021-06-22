<?php
namespace App\Controllers;
use App\Controller;
use App\Models\Product;
use App\Models\Article;

class Home extends Controller{

    //Home page
    public function index(){
        $title="Accueil";
      	$product = new Product();
      $articles = new Article();

        //Get the flash message then delete it
        $flash = '';
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

      $_SESSION['active']='accueil';

    	$products = $product->getAll();
    	$articles = $articles->getAll();
        $this->render('index',compact('title','products','articles','flash'));
    }

  public function boutique(){
    $title="Boutique";
    $products=new Product();
    $products = $products->getAll();
      $_SESSION['active']='boutique';

    $this->render('boutique',compact('title','products'));
  }

  public function blog(){
    $title="Blog";
    $articles=new Article();
    $articles = $articles->getAll();
          $_SESSION['active']='blog';


    $this->render('blog',compact('title','articles'));
  }

  public function contact(){
    $title="Nous contacter";

    $_SESSION['active']='contact';


    $this->render('contact',compact('title','articles'));
  }
}