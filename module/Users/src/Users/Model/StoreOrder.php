<?php
namespace Users\Model;

class StoreOrder
{
    #Attributs
          public $id;
          public $store_product_id; // nom utilisateur 
          public $qty; //email de l'utilisateur
          public $total; 
          public $status;
          public $stamp;
          public $first_name;
          public $last_name;
          public $email;
          public $ship_to_stree;
          public $ship_to_city;
          public $ship_to_state;
          public $ship_to_zip; 
          
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
                 $this->id = (isset($data['id'])) ? $data['id'] : null;
                 $this->store_product_id = (isset($data['store_product_id'])) ? $data['store_product_id'] : null;
                 $this->qty = (isset($data['qty'])) ? $data['qty'] : null;
                 $this->total = (isset($data['total'])) ? $data['total'] : null;
                 $this->status = (isset($data['status'])) ? $data['status'] : null;
                 $this->stamp = (isset($data['stamp'])) ? $data['stamp'] : null;
                 $this->first_name = (isset($data['first_name'])) ? $data['first_name'] : null;
                 $this->last_name = (isset($data['last_name'])) ? $data['last_name'] : null;
                 $this->ship_to_stree = (isset($data['ship_to_stree'])) ? $data['ship_to_stree'] : null;
                 $this->email = (isset($data['email'])) ? $data['email'] : null;
                 $this->ship_to_stree = (isset($data['ship_to_stree'])) ? $data['ship_to_stree'] : null;
                 $this->ship_to_city = (isset($data['ship_to_city'])) ? $data['ship_to_city'] : null;
                 $this->ship_to_state = (isset($data['ship_to_state'])) ? $data['ship_to_state'] : null;
                 $this->ship_to_zip = (isset($data['ship_to_zip'])) ? $data['ship_to_zip'] : null;
                 
                
              }



     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

   



}
    