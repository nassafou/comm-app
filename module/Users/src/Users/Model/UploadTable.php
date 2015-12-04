<?php
namespace Upload\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class UploadTable
{
    #Attribut
      protected $tableGateway;
      
      #constantes
      
      
      #Methodes
      
      // constructeur pour initialiser les enregistrements de la tableGateway
    public function __construct(TableGateway $tableGateway , TableGateway $uploadSharingTableGateway)
     {
        $this->tableGateway = $tableGateway;
        
        $this->uploadSharingTableGateway = $uploadSharingTableGateway;

        
        
       }
       
       
       public function fetchAll()
         {
            $resultSet = $this->tableGateway->select();
                 return $resultSet;
         }
         
         
         public function getUploadsByUserId($userId)
          {
                 $userId = (int) $userId;
               $rowset = $this->tableGateway->select(
                   array('user_id' => $userId));
                         return $rowset;
          }


         
         public function deleteUpload($id)
             {
                   $this->tableGateway->delete(array('id' => $id));
              }




       
       // fonction d'enregistrement d'un utilisateur
    public function saveUpload(Upload $upload)
     {
       $data = array(
        'filename' => $upload->filename,
        'label' => $upload->label,
    'user_id' => $upload->user_id,
      );
        $id = (int)$upload->id;
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
       
      public function getUpload($id)
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
                  *Partie sharing upload
                  *
                  *
                  */
                 
                 //Ajout d'une permission de partage a un utilisateur
                 
                 public function addSharing($uploadId, $userId)
               {
                   $data = array(
                   'upload_id' => (int)$uploadId,
                   'user_id' => (int)$userId,
                );

                $this->uploadSharingTableGateway->insert($data);
                }
 
                 
                 //Enlever la permission de partage de telechargement d' un utilisateur     
                 
                 
                 public function removeSharing($uploadId, $userId)
                 {
                    $data = array(
                      'upload_id' => (int)$uploadId,
                      'user_id' => (int)$userId,
                            );
                  $this->uploadSharingTableGateway->delete($data);
                 }
                 
                 // liste des utilisateurs dont les téléchargements sont partagés
                 
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
                     function (Select $select) use ($userId){$select->columns(array())
                                                                     ->where(array('uploads_sharing.user_id'=>$userId))
                                                                     ->join('uploads', 'uploads_sharing.upload_id = uploads.id');
                                                                 });
                                                return $rowset;
                  }
  
}

                 
                 
                 
                 
                 
                 

