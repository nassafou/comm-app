<?php
namespace ChatMessages\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class ChatMessagesTable
{
    #Attribut
      protected $tableGateway;
      protected $ChatMessagesTableGateway;
      
      #constantes
      
      
      #Methodes
      
      // constructeur pour initialiser les enregistrements de la tableGateway
    public function __construct(TableGateway $tableGateway, TableGateway $ChatMessagesTableGateway)
     {
        $this->tableGateway = $tableGateway;
        $this->ChatMessagesTableGateway = $ChatMessagesTableGateway;
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

         
         public function deleteChatMessage($id)
             {
                   $this->tableGateway->delete(array('id' => $id));
              }




       
       // fonction d'enregistrement d'un utilisateur
    public function saveUser(chat_messages $chat_messages)
     {
       $data = array(
        'user_id' => $chat_messages->user_id,
        'message' => $chat_messages->message,
    'stamp' => $chat_messages->stamp,
      );
        $id = (int)$chat_messages->id;
         if ($id == 0) {
           $this->tableGateway->insert($data);
         } else {
           if ($this->getChatMessages($id)) {
                $this->tableGateway->update($data, array('id' => $id));
               } else {
                  throw new \Exception('Utilisateur  ID n existe pas');
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
       
      public function getChatMessages($id)
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
