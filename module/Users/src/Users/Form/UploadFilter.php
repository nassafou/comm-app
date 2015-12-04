<?php
namespace Users\Form;
use Zend\InputFilter\InputFilter;

class UploadFilter extends InputFilter
{
public function __construct()
{
    /*
    $this->add(array(
    'required' => true,
      'validators' => array(
                          array(
                               'name' => 'EmailAddress',
                               'options' => array(
                                     'domain' => true,
                                       ),
                              ),
                      ),
               ));
    */
    
    
    
    
    
    $this->add(array(
                    'name' => 'name',
                      'required' => true,
                              'filters' => array(
                                         array(
                                         'name' => 'StripTags',
                                                         ),
                                                        ),
                              
            'validators' => array(
                  array(
                       'name' => 'StringLength',
                          'options' => array(
                                 'encoding' => 'UTF-8',
                                        'min' => 2,
                                         'max' => 140,
                                          ),
                                   ),
                             ),
                       ));


    
    
    $this->add(array(
                   'name' => 'fileupload',
                     'required' => true,
                      'filters' => array(                                         
                'target'   => './data/blog_',
                'use_upload_extension' => true,
                'randomize' => true,                                                                                        
        ),  
                                                              ));
    
    
    
    
    
        // $this->add(array(    
         // 'name' => 'password',
          //'required' => true,
    
               // ));
    
    
                /* $this->add(array(
                            'name' => 'confirm_password',
                            'required' => true,
                                        )); */
    
    
    
    
  }
}