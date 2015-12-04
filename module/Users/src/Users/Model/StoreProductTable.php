<?php
namespace Users\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Users\Model\StoreProductTable;
use Users\Model\StoreOrderTable;


class StoreProductTable
{
    #Attribut
      protected $tableGateway;
      protected $StoreProductGateway;
      
      #constantes
      
      
      #Methodes
      
      // constructeur pour initialiser les enregistrements de la tableGateway
    public function __construct(TableGateway $tableGateway, TableGateway $StoreProductTableGateway)
     {
        $this->tableGateway = $tableGateway;
       // $this->StoreProductTableGateway = $StoreProductGateway;
       }
       
       
       public function fetchAll()
         {
            $resultSet = $this->tableGateway->select();
                 return $resultSet;
         }
         
         
         public function getUserByEmail($userEmail)
          {
             $rowset = $this->tableGateway->select(array('email' => $userEmail));
            $row = $rowset->current();
               if (!$row) {
                    throw new \Exception("Impossible de trouver row $ userEmail");
                         }
                          return $row;
         }

         
         public function deleteStoreProduct($id)
             {
                   $this->tableGateway->delete(array('id' => $id));
              }




       
       // fonction d'enregistrement d'un utilisateur
    public function saveUser(store_products $store_products)
     {
       $data = array(
        'id' => $store_products->id,
        'name' => $store_products->name,
        'desc' => $store_products->desc,
         'cost' => $store_products->cost,
      );
        $id = (int)$store_products->id;
         if ($id == 0) {
           $this->StoreProductTableGateway->insert($data);
         } else {
           if ($this->getStoreProduct($id)) {
                $this->tableGateway->update($data, array('id' => $id));
               } else {
                  throw new \Exception('Produit  ID n existe pas');
                           }
                        }
                   }
                   
       
       // function d'obtention de l'id utilisateur
       
      public function getUser($id)
      { 
                $id = (int) $id;
                 $rowset = $this->tableGateway->select(array('id' => $id));
                 $row = $rowset->current();
               if (!$row) {
                     throw new \Exception("Impossible de trouver   $id");
                          }
                     return $row;
                 }
                 
                 
                 
                 
                 
                 // function d'obtention de l'id utilisateur
       
      public function getStoreProduct($id)
      { 
                $id = (int) $id;
                 $rowset = $this->tableGateway->select(array('id' => $id));
                 $row = $rowset->current();
               if (!$row) {
                     throw new \Exception("Impossible de trouver   $id");
                          }

                     return $row;
      }
      
      /*
      public function getLoggedInUser()
      {
         $this->
         
         
      }
      
      */
      
      
      
      
      
 }
