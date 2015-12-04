<?php
// filename : module/Users/src/Users/Form/RegisterForm.php
namespace Users\Form;
use Zend\Form\Form;

class SForm extends Form
{
      public function __construct($name = null)
       {
              parent::__construct('Store');
              $this->setAttribute('method', 'post');
              $this->setAttribute('enctype','multipart/formdata');

      $this->add(array(
                  'name' => 'id',
                 'type' => 'Hidden',
                        
                        )); 
                  
                  #Sujet ou objet du mail
                  $this->add(array(
                  'name' => 'name',
                 'attributes' => array(
                        'type' => 'text',
                 ),
                 'options' => array(
                     'label' => 'Subject',
                             ),
                        ));          
               
               
               #Choix d'un destinataire
               
               
               $this->add(array(
                                
                              'type' => 'Zend\From\Element\Select',
                              'name ' => 'destinataire',
                              'options' => array(
                                  'label'   => 'A',
                                  'Value_options' => array(
                                            '1'  => 'Selectionner utilisateur',
                                            '2'  => 'nassafou@gmail.com',
                                            '3'  => 'test@gmail.com',
                                                           ),
                                                 
                                                 
                                                 ),
                                
                                
                                
                                )
                          );
               
               
               #Adresse email
               
        $this->add(array(
              'name' => 'email',
                 'attributes' => array(
                           'type' => 'email',
                                ),              

                        'options' => array(
                            'label' => 'Email',
                                  ),
                      'attributes' => array(
                           'required' => 'required',
                           'placeholder' => 'email@domain.com',
                                      ),
                            'filters' => array(
                                           array('name' => 'StringTrim'),
                                             ),
                            
                     'validators' => array(
                                            array(
                                           'name' => 'EmailAddress',
                                           'options' => array(
                                           'messages' => array(
                               \Zend\Validator\EmailAddress::INVALID_FORMAT => 'Email address format is invalid'
                         )
                      )
                  )
             )
       ));
             
             
             #Message a envoyer
             
              $this->add(array(
                  'name' => 'message',
                 'attributes' => array(
                        'type' => 'textarea',
                 ),
                 'options' => array(
                     'label' => 'Message',
                             ),
                        )); 
             
             
             /*  
               
            $this->add(array(
                
                  'name' => 'password',
                 'attributes' => array(
                        'type' => 'password',
                 ),
                 'options' => array(
                     'label' => 'Mot de passe',
                             ),
                        ));
            
            */
            /*
             $this->add(array(
                
                  'name' => 'confirm_password',
                 'attributes' => array(
                        'type' => 'password',
                 ),
                 'options' => array(
                     'label' => 'Comfirmation mot de passe ',
                             ),
                        )); */
            
            #Bouton d'envoie
            
             $this->add(array(
                
                  'name' => 'submit',
                 'attributes' => array(
                        'type' => 'submit',
                        'value' => 'Envoyer',
                        'id' => 'submitbutton',
                                ),
                 ));
           }
}