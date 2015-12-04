<?php
namespace Users\Model;
class User
{
    #Attributs
          public $id;
          public $name; // nom utilisateur 
          public $email; //email de l'utilisateur
          public $password; // mot de passe  de l'utisateur

    #Constantes
    
    
    
    
    #Methodes
    
    // fonction utilisée pour assigner le hachage  MD5 aux mots de passe dans le UserTable
    
    public function setPassword($clear_password)
       {
           $this->password = md5($clear_password);
        }


    //fonction utilisée pour mapper l'utilisateur dans la table UserTable

          function exchangeArray($data)
             {
                 $this->id = (isset($data['id'])) ?
                $data['id'] : null;
               $this->name = (isset($data['name'])) ?
                $data['name'] : null;
                 $this->email = (isset($data['email'])) ?
                  $data['email'] : null;
                if (isset($data["password"]))
                      {
                           $this->setPassword($data["password"]);
                      }
              }



     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

   



}
    