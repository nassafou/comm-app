<?php
namespace Users\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Users\Model\ChatMessagesTable;


class UserTable
{
    #Attribut
      protected $tableGateway;
      
      #constantes
      
      
      #Methodes
      
      // constructeur pour initialiser les enregistrements de la tableGateway
    public function __construct(TableGateway $tableGateway)
     {
        $this->tableGateway = $tableGateway;
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

         
         public function deleteUser($id)
             {
                   $this->tableGateway->delete(array('id' => $id));
              }




       
       // fonction d'enregistrement d'un utilisateur
    public function saveUser(User $user)
     {
       $data = array(
        'email' => $user->email,
        'name' => $user->name,
    'password' => $user->password,
      );
        $id = (int)$user->id;
         if ($id == 0) {
           $this->tableGateway->insert($data);
         } else {
           if ($this->getUser($id)) {
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
                 
                 
                 
                 
                 public function addChat($ChatMessagesId, $userId)
                    {
                          $data = array(
                                   'chat_id' => (int)$ChatMessagesId,
                                    'user_id' => (int)$userId,
                                        );
                              $this->ChatMessagesTableGateway->insert($data);
                       }
                       
                       
                       public function removeChat($ChatMessageId, $userId)
                           {
                                  $data = array(
                                    'chat_id' => (int)$uploadId,
                                     'user_id' => (int)$userId,
                                           );
                                    $this->ChatMessagesTableGateway->delete($data);
                                   }

                                   
              public function getSharedUsers($uploadId)
              {
                   $uploadId = (int) $uploadId;
                   $rowset = $this->uploadSharingTableGateway->select(
                  array('upload_id' => $uploadId));
                return $rowset;
               }

                 public function getSharedUploadsForUserId($userId)
               {
                   $userId = (int) $userId;
                   $rowset = $this->uploadSharingTableGateway->select(
                      function (Select $select) use ($userId){
                           $select->columns(array())
                                  ->where(array('uploads_sharing.user_id'=>$userId))
                                  ->join('uploads', 'uploads_sharing.upload_id = uploads.id');
                                });
                           return $rowset;
               }
               
                public function getLoggedUserId($userId)
               {
                   $userId = (int) $userId;
                   $rowset = $this->uploadSharingTableGateway->select(
                      function (Select $select) use ($userId){
                           $select->columns(array())
                                  ->where(array('uploads_sharing.user_id'=>$userId))
                                  ->join('uploads', 'uploads_sharing.upload_id = uploads.id');
                                });
                           return $rowset;
               }
        
                       
                       

 }
