<?php
// filename : module/Users/src/Users/Form/RegisterForm.php
namespace Users\Form;
use Zend\Form\Form;

class LoginForm extends Form
{
      public function __construct($name = null)
       {
              parent::__construct('Login');
              $this->setAttribute('method', 'post');
              $this->setAttribute('enctype','multipart/formdata');

      $this->add(array(
                  'name' => 'id',
                 'type' => 'Hidden',
                        
                        )); 
                            
               
        $this->add(array(
              'name' => 'email',
                 'attributes' => array(
                           'type' => 'email',
                                ),              

                        'options' => array(
                            'label' => 'Email',
                                  ),
                      'attributes' => array(
                           'required' => 'required'
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
               
               
            $this->add(array(
                
                  'name' => 'password',
                 'attributes' => array(
                        'type' => 'password',
                 ),
                 'options' => array(
                     'label' => 'Mot de passe',
                             ),
                        ));
            
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
            
             $this->add(array(
                
                  'name' => 'submit',
                 'attributes' => array(
                        'type' => 'submit',
                        'value' => 'Connexion',
                        'id' => 'submitbutton',
                                ),
                 ));
           }
}