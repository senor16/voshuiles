<?php

namespace App\Models;

use App\Model;

class Product extends Model
{
    // Set the name of the table to use
    public function __construct()
    {
        $this->table = "product";
        $this->getConnexion();
    }

    public function add($fields = [])
    {
        $sql = "INSERT INTO {$this->table} (designation,qualite,prix,description,quantite,producteur,image)
				VALUES (:designation, :qualite, :prix, :description, :quantite, :producteur, :image)";
        $query = $this->connexion->prepare($sql);
        try {

            $query->execute([
                'designation' => $fields['designation'],
                'qualite' => $fields['quality'],
                'prix' => $fields['price'],
                'description' => $fields['description'],
                'quantite' => $fields['quantity'],
                'producteur' => $fields['owner'],
                'image' => $fields['image']
            ]);
            return $this->connexion->lastInsertId();
        } catch (\PDOException $exception) {
//            die('Erreur add client : ' . $exception->getMessage());
            return false;
        }
    }

    public function update($fields = [])
    {
        $sql = "UPDATE {$this->table} SET designation=:designation,qualite=:qualite,prix=:prix,description=:description,quantite=:quantite
                        WHERE id=:id";
        $query = $this->connexion->prepare($sql);
        try {

            $query->execute([
                'designation' => $fields['designation'],
                'qualite' => $fields['quality'],
                'prix' => $fields['price'],
                'description' => $fields['description'],
                'quantite' => $fields['quantity'],
                'id'=>$fields['id']
            ]);
            return true;
        } catch (\PDOException $exception) {
//            die('Erreur update : ' . $exception->getMessage());
            return false;
        }
    }

    public function updateImage($image,$id){
        $sql = "UPDATE {$this->table} SET image=:image WHERE id=:id";
        $query = $this->connexion->prepare($sql);
        try {

            $query->execute([
                'image'=>$image,
                'id'=>$id
            ]);
            return true;
        } catch (\PDOException $exception) {
//            die('Erreur Update image : ' . $exception->getMessage());
            return false;
        }
    }

    public function getProductsOf($id)
    {
        try {
            $sql = "SELECT * FROM " . $this->table." WHERE producteur=:id ORDER BY id DESC";
            $query = $this->connexion->prepare($sql);
            $query->execute(['id'=>$id]);
            return $query->fetchAll();
        } catch (\PDOException $exception) {
//            die("Error GetProductsOff " . $exception->getMessage());
            return false;

        }
    }


}