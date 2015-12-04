<?php
namespace Upload\Model;
class Upload
{
    #Attributs
          public $id; //identifiant du fichier
          public $filename; // nom du fichier
          public $label; //étiquette du fichier
          public $user_id; // identifiant de l'utilisateur
                    

    #Constantes
    
    
    
    
    #Methodes
    
    // fonction utilisée pour assigner le hachage  MD5 aux mots de passe dans le UserTable
    
   


    //fonction utilisée pour mapper l'utilisateur dans la table UserTable

          function exchangeArray($data)
             {
                /// $this->id = (isset($data['id'])) ?
                //$data['id'] : null;
               $this->filename = (isset($data['filename'])) ?
                $data['filename'] : null;
                 $this->label = (isset($data['label'])) ?
                  $data['label'] : null;
                  $this->user_id = (isset($data['user_id'])) ?
                  $data['user_id'] : null;
                
              }




    public function getArrayCopy()
     {
         return get_object_vars($this);
     }


}
    