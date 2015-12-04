<?php
// filename : module/Users/src/Users/Form/RegisterForm.php
namespace Users\Form;
use Zend\Form\Form;

class UploadForm extends Form
{
      public function __construct($name = null)
       {
              parent::__construct('Upload');
              $this->setAttribute('method', 'post');
              $this->setAttribute('enctype','multipart/formdata');
              
              

      $this->add(array(
                  'name' => 'name',
                 'attributes' => array(
                        'type' => 'text',
                 ),
                 'options' => array(
                     'label' => 'Description du fichier',
                             ),
                        ));

               
           $this->add(array(
                   'name' => 'fileupload',
                     'attributes' => array(
                               'type' => 'file',
                                             ),
                           'options' => array(
                                      'label' => 'File Upload',
                                                            ),
                                                              ));

               
                           
            
             $this->add(array(
                
                  'name' => 'submit',
                 'attributes' => array(
                        'type' => 'submit',
                        'value' => 'Telecharger',
                        'id' => 'submitbutton',
                 ),
                 
                        ));
           }
}