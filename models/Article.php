<?php

namespace App\Models;

use App\Model;

class Article extends Model
{
    // Ser the name of the table to use
    public function __construct()
    {
        $this->table = "article";
        $this->getConnexion();
    }

  public function getOneBySlug($slug){
    try {
            $sql = "SELECT * FROM {$this->table} WHERE slug = :slug";
            $query = $this->connexion->prepare($sql);
            $query->execute(['slug' => $slug]);
            return $query->fetch();
        } catch (PDOException $exception) {
            die("Error getOne " . $exception->getMessage());
        }
  }

}