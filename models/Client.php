<?php
namespace App\Models;

use App\Model;
use \PDO;
use \PDOException;



class Client extends Model{

  // Ser the name of the table to use
  public function __construct(){
    $this->table="client";
    $this->getConnexion();
  }

  //Add a user to the database
  public function signup(array $fields=[]){
  	$sql = "INSERT INTO {$this->table} (nom,prenom,email,password,tel,genre,ville,date_naiss)
				VALUES (:nom,:prenom,:email,:password, :tel,:genre,:ville,:date_naiss)";
		$query = $this->connexion->prepare($sql);
		try{
			$query->execute([
			    'nom'=>$fields['last_name'],
                'prenom'=>$fields['first_name'],
                'tel'=>$fields['tel'],
                'email'=>$fields['email'],
                'password'=>$fields['password'],
                'genre'=>$fields['gender'],
                'ville'=>$fields['town'],
                'date_naiss'=>$fields['birth_date'],
							]);
			return $this->connexion->lastInsertId();
		}catch(PDOException $exception){
			die('Erreur add client : '.$exception->getMessage());
		}
  }

    //Connect a user
    public function login(array $fields=[]){
        $sql = "SELECT * FROM {$this->table} WHERE tel = :tel OR email=:tel";
        $query= $this->connexion->prepare($sql);
        try{
            $query->execute(['tel'=>$fields['tel']]);
            $client= $query->fetch();
            if(!empty($fields['remember']) && $client->a_id){
                $q = $this->connexion->prepare("UPDATE {$this->table} SET remember = :remember WHERE id = {$auth->id}");
                $q->execute(['remember'=>$fields['remember']]);
            }
            return $client;
        }catch(PDOException $exception){
            die('Erreur login Client : '.$exception->getMessage());
        }
    }


}