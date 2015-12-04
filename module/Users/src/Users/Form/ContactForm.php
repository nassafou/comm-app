<?php
namespace Users\Form;

use Zend\Form\Form;

class ContactForm extends Form
{

    Public function __construct($name = null)
    { parent:: __construct('Contact');
       $this->setAttribute('method', 'post');
       $this->setAttribute('enctype','multipart/formdata');


 $this->add( array(

         'name'   => 'name',
         
         'attributes' => array(
                        'type' => 'text',
                 ),
         
         
         
         
         'options' => array(
                     'label' => 'Nom complet',
                             ),
         
         
         ) );

      $this->add( array(

         'name'   => 'email',
         'type'   => 'email',
         'options'=> array('label' => 'Votre mail')) );


        $this->add( array(

         'name'   => 'message',
         'type'   => 'textarea',
         'options'=> array('label' => 'Message')) );


        $this->add( array(

         'name'   => 'envoyer',
         'type'   => 'submit',
         'attributes'=> array(
          'value' => 'Send',
         'id'     => 'submitbutton')) );

  

          }

}
