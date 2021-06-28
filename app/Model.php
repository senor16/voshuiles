<?php

namespace App;


abstract class Model
{
    //Connexion information
    private string $dbname = "projet";
    private string $host = "localhost";
    private string $username = "root";
    private string $password = "dedma16";

    //Tables
    public string $table;
    public $id;

    //connexion instance
    protected $conneion;

//Connect a user
    public function login(array $fields = [])
    {
        $sql = "SELECT * FROM {$this->table} WHERE tel = :tel OR email=:tel";
        $query = $this->connexion->prepare($sql);
        try {
            $query->execute(['tel' => $fields['tel']]);
            $user = $query->fetch();
            if (!empty($fields['remember_token']) && $user->id) {
                $q = $this->connexion->prepare("UPDATE {$this->table} SET remember = :remember WHERE id = {$user->id}");
                $q->execute(['remember' => $fields['remember_token']]);
            }
            return $user;
        } catch (\PDOException $exception) {
//            die('Erreur login : ' . $exception->getMessage());
            return false;
        }
    }

    //Get the instance of an connexion
    public function getConnexion()
    {
        $this->connexion = null;
        try {
            $this->connexion = new \PDO("mysql:host=" . $this->host . "; dbname=" . $this->dbname, $this->username, $this->password);
            $this->connexion->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            $this->connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connexion->exec("set names utf8");
        } catch (\PDOException $exception) {
//            die("Error Connexion " . $exception->getMessage());
            return false;
        }
    }

    //Function with get all the records of a table
    //It returns it as object
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM " . $this->table." ORDER BY id DESC";
            $query = $this->connexion->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (\PDOException $exception) {
//            die("Error GetAll " . $exception->getMessage());
            return false;
        }
    }

    //Function with get one record on with it's id
    //args : $id the id of the record
    public function getOne($id)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $query = $this->connexion->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (\PDOException $exception) {
//            die("Error getOne " . $exception->getMessage());
            return false;
        }
    }

    //Function with get all records ontaining a key in the title or in the content
    //args : $q the key
    public function search(string $q)
    {
        try {
            $sql = "SELECT * FROM " . $this->table;
            $sql = $sql . " WHERE designation LIKE ('%" . $q . "%')";
            $query = $this->connexion->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (\PDOException $exception) {
//            die("Error search " . $exception->getMessage());
            return false;
        }
    }

    /*
        Delete an record by his id
    */
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM " . $this->table . " WHERE id=" . $id;
            $query = $this->connexion->prepare($sql);
            $query->execute();
            return true;
        } catch (\PDOException $exception) {
//            die('Error deletePress : ' . $exception->getMessage());
            return false;
        }
    }
}
