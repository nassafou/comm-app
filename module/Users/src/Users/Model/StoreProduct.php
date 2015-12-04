<?php
namespace StoreProduct\Model;

class StoreProduct
{
    #Attributs
          public $id;
          public $name; 
          public $desc; 
          public $cost; 
          
          
    #Constantes
    
    
    
    
    #Methodes
    
    // fonction utilisée pour assigner le hachage  MD5 aux mots de passe dans le UserTable
    
    public function setPassword($clear_password)
       {
           $this->password = md5($clear_password);
        }




          function exchangeArray($data)
             {
                 $this->id = (isset($data['id'])) ?
                $data['id'] : null;
               $this->name = (isset($data['name'])) ?
                $data['name'] : null;
                 $this->desc = (isset($data['desc'])) ?
                  $data['desc'] : null;
                  
                  $this->cost = (isset($data['cost'])) ?
                  $data['cost'] : null;
                  
                
              }



     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

   



}
    