<?php
namespace ChatMessages\Model;



class ChatMessages
{
    #Attributs
          public $id;
          public $user_id; // nom utilisateur 
          public $message; //email de l'utilisateur
          public $stamp; // mot de passe  de l'utisateur

    #Constantes
    
    
    
    
    #Methodes
    
    

    //fonction utilisée pour mapper l'utilisateur dans la table UserTable

          function exchangeArray($data)
             {
                $this->id = (isset($data['id'])) ?
                $data['id'] : null;
                $this->user_id = (isset($data['user_id'])) ?
                $data['user_id'] : null;
                $this->message = (isset($data['message'])) ?
                $data['message'] : null;
               
                $this->stamp = (isset($data['stamp'])) ?
                  $data['stamp'] : null;
                  
               
              }



     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

   



}
    