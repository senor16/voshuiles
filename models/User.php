<?php
namespace App\Models;

use App\Model;



class User extends Model{

  // Ser the name of the table to use
  public function __construct(){
    $this->table="user";
    $this->getConnexion();
  }

  //Add a user to the database
  public function signup(array $fields=[]){
  	$sql = "INSERT INTO {$this->table} (nom,prenom,email,password,tel,genre,ville,date_naiss,role)
				VALUES (:nom,:prenom,:email,:password, :tel,:genre,:ville,:date_naiss,:role)";
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
                'role'=>$fields['role'],
							]);
			return $this->connexion->lastInsertId();
		}catch(\PDOException $exception){
//			die('Erreur sign up : '.$exception->getMessage());
            return false;
		}
  }

  public function update(array $fields=[], $id){
      $sql = "UPDATE {$this->table} 
				SET nom=:nom, prenom=:prenom, email=:email, tel=:tel, genre=:genre, ville=:ville, date_naiss=:date_naiss,role=:role
				WHERE id=:id";
      $query = $this->connexion->prepare($sql);
      try{
          $query->execute([
              'nom'=>$fields['last_name'],
              'prenom'=>$fields['first_name'],
              'tel'=>$fields['tel'],
              'email'=>$fields['email'],
              'genre'=>$fields['gender'],
              'ville'=>$fields['town'],
              'date_naiss'=>$fields['birth_date'],
              'role'=>$fields['role'],
              'id'=>$id
          ]);
          return true;
      }catch(\PDOException $exception){
//          die('Erreur update user : '.$exception->getMessage());
          return false;
      }
  }

  public function updatePassword($password, $id){
      $sql = "UPDATE {$this->table} 
				SET password=:password
				WHERE id=:id";
      $query = $this->connexion->prepare($sql);
      try{
          $query->execute([
              'password'=>$password,
              'id'=>$id
          ]);
          return true;
      }catch(\PDOException $exception){
//          die('Erreur update password : '.$exception->getMessage());
          return false;
      }
  }
}