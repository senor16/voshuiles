<?php


namespace App\Controllers;

use App\Controller;


class Article extends Controller
{

    /**
     * Check the validity of the title of an article
     * return true if a last name is valid and false if not
     * @param string $title
     * @return bool
     */
    public function checkTitle(string $title):bool{
        return !(empty($first_name) || ! preg_match("/^[a-zA-Zéèïëçêâôöòóù\-]+$/", $first_name) ||
            strlen($first_name) > 20);
    }

    /**
     * Add an article
     * @param array $fields
     */
    public function add(array $fields=[]){

    }



}