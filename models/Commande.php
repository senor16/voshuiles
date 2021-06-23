<?php


namespace App\Models;


class Commande extends \App\Model
{

    // Set the name of the table to use
    public function __construct()
    {
        $this->table = "commande";
        $this->getConnexion();
    }

    public function add($user, $product, $quantite, $lieu_livraison)
    {
        $sql = "INSERT INTO {$this->table} (user,product,quantite,lieu_livraison)
				VALUES (:user,:product,:quantite,:lieu_livraison)";
        $query = $this->connexion->prepare($sql);
        try {


            $query->execute([
                'user'=>$user,
            'product'=>$product,
            'quantite'=>$quantite,
            'lieu_livraison'=>$lieu_livraison
            ]);

            return $this->connexion->lastInsertId();
        } catch (\PDOException $exception) {

//            die('Erreur add client : ' . $exception->getMessage());
            return false;
        }
    }
}