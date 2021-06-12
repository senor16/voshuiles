<?php
namespace App\Models;
use App\Model;

class Product extends Model{
  // Ser the name of the table to use
  public function __construct(){
    $this->table="product";
    $this->getConnexion();
  }
}