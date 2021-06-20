<?php

namespace App\Controllers;

use App\Controllers\Errors;
use App\Models\Article;

class Articles extends \App\Controller
{

    //Show the content of an article
    public function show($slug)
    {
      $article = new Article();
      $article = $article->getOneBySlug($slug);
      if($article){
         $flash="";
      if(isset($_SESSION['flash']['alert'])){
        $flash = $_SESSION['flash']['alert'];
        unset($_SESSION['flash']);
      }
        $title=$article->titre;
		$this->render('show',compact('title','article','flash'));
      }else{
        (new HttpErrors())->notFound();

      }
    }
}