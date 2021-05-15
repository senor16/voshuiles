<?php
namespace App\Controllers;
use App\Controller;

class HttpErrors extends Controller{
    //Render the page not found error
    public function notFound()
    {
        require_once ROOT.'views/Errors/notfound.php';
        require_once ROOT.'views/layout/default.php';
    }
}