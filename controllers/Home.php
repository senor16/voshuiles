<?php
namespace App\Controllers;
use App\Controller;

class Home extends Controller{

    //Home page
    public function index(){
        $title="Home";
        $this->render('index',compact('title'));
    }
}