<?php
namespace Users\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Users\Model\StoreOrderTable;


class StoreOrderTable
{
    #Attribut
      protected $tableGateway;
      protected $StoreOrderGateway;
      
      #constantes
      
      
      #Methodes
      
      // constructeur pour initialiser les enregistrements de la tableGateway
    public function __construct(TableGateway $tableGateway, TableGateway $StoreOrderTableGateway)
     {
        $this->tableGateway = $tableGateway;
        $this->StoreOrderTableGateway = $StoreOrderGateway;
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

         
         public function deleteStoreOrder($id)
             {
                   $this->tableGateway->delete(array('id' => $id));
              }




       
       // fonction d'enregistrement d'un utilisateur
    public function saveStoreOrder(store_orders $store_orders)
     {
       $data = array(
               'id'        => $store_orders->id,
        'store_product_id' => $store_orders->store_product_id,
                     'qty' => $store_orders->qty,
                   'total' => $store_orders->total,
                  'status' => $store_orders->status,
                   'stamp' => $store_orders->stamp,
              'first_name' => $store_orders->first_name,
               'last_name' => $store_orders->last_name,
                   'email' => $store_orders->email,
           'ship_to_stree' => $store_orders->ship_to_stree,
            'ship_to_city' => $store_orders->ship_to_city,
           'ship_to_state' => $store_orders->ship_to_state,
             'ship_to_zip' => $store_orders->ship_to_zip,
        
      );
        $id = (int)$store_orders->id;
         if ($id == 0) {
           $this->StoreOrderTableGateway->insert($data);
         } else {
           if ($this->getStoreOrder($id)) {
                $this->tableGateway->update($data, array('id' => $id));
               } else {
                  throw new \Exception('Order  ID n existe pas');
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
       
      public function getStoreOrder($id)
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
