<?php

namespace App\Controllers;

use App\Controller;

/**
 * Class Product
 * Use to handle actions about products
 * @package App\Controllers
 */
class Products extends Controller{
    private array $qualities = ['blanc', 'noir'];
    private array $conditioning = ['litre','carton'];

    /********************************************************
     *                                                       *
     *   Functions used to check the validity of fields      *
     *                                                       *
     ********************************************************/

    /**
     * Check if the chosen quality exists
     * Return true if it exists and false if not
     * @param string $qualite
     * @return bool
     */
    public function checkQuality(string $qualite):bool{
        return in_array($qualite,$this->qualities);
    }

    /**
     * Check if the chosen conditioning exists
     * Return true if it exists and false if not
     * @param string $cond
     * @return bool
     */
    public function checkConditioning(string $cond):bool{
        return in_array($cond, $this->conditioning);
    }

    /**
     * Check the validity of the product description
     * Return true if it exists and false if not
     * @param string $description
     * @return bool
     */
    public function checkDescription(string $description):bool{
        return !(empty($description) || strlen($description)<5);
    }

    /**
     * Function to add a product to the store
     * @param array $fields
     */
    public function add(array $fields=[]){
        $result['error']=false;
        $resut['message']=[];
        if (!isset($fields['quality']) || !$this->checkQuality($fields['quality'])){
            $result['error']=true;
            $result['message']['quality']="Choix invalide";
        }

        if (!isset($fields['conditioning']) || !$this->checkConditioning($fields['conditioning'])){
            $result['error']=true;
            $result['message']['conditioning']="Choix invalide";
        }

        if (!isset($fields['description']) || !$this->checkDescription($fields['description'])){
            $result['error']=true;
            $result['message']['description']="Veuillez entrer plus de 5 caractères";
        }

        if (!isset($fields['price']) || !is_integer($fields['price']) ){
            $result['error']=true;
            $result['message']['price']="Entrez un montant valide.";
        }



        if(!$result['error']){
            $result['info']="Produit ajouté avec succès";
        }

        $this->showJson($result);
    }

    /**
     * Update product informations
     * @param array $fields
     */
    public function update(array $fields=[]){
        $result['error']=false;
        $resut['message']=[];
        if (isset($fields['quality']) && !$this->checkQuality($fields['quality'])){
            $result['error']=true;
            $result['message']['quality']="Choix invalide";
        }

        if (isset($fields['conditioning']) && !$this->checkConditioning($fields['conditioning'])){
            $result['error']=true;
            $result['message']['conditioning']="Choix invalide";
        }

        if (isset($fields['description']) && !$this->checkDescription($fields['description'])){
            $result['error']=true;
            $result['message']['description']="Veuillez entrer plus de 5 caractères";
        }

        if (isset($fields['price']) && !is_integer($fields['price']) ){
            $result['error']=true;
            $result['message']['price']="Entrez un montant valide.";
        }



        if(!$result['error']){
            $result['info']="Produit modifié ajouté avec succès";
        }

        $this->showJson($result);
    }

    /**
     * Delete a product
     * @param $id
     */
    public function delete($id){

    }



    /**
     * Function to test user actions about product
     * @param string $action
     */
    public function test(string $action){
        switch($action){
            case "add":
                $fields['quality']="blanc";
                $fields['conditioning']="litre";
                $fields['description']="Très bon produit. Beurre de karité.";
                $fields['price']=400;
                $this->add($fields);
                break;
            case "update":
                $fields['quality']="blanc";
                $fields['conditioning']="litre";
                $fields['description']="Très bon produit. Beurre de karité.";
                $fields['price']='400f';
                $this->update($fields);
                break;
        }
    }



}