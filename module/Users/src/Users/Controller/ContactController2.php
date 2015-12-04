<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\ContactForm;
use Users\From\ContactFilter;
use Zend\Mail\Message;

use Zend\Mail\Transport\Sendmail;
use Zend\Mail;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

  class ContactController extends AbstractActionController
  {
       public function indexAction()
       {

          // return new ViewModel();
          $form = new ContactForm();
          
               $request = $this->getRequest();
          if($request->isPost())
             {

                $message = new \Zend\Mail\Message();
                $message->setBody($_POST['message']);
                $message->setForm($_POST['EmailAdress']);
                $message->setSubject(" contact message ");
                $message->addTo('ntyoussouf@gmail.com');
               
                $smtpOptions = new \Zend\Mail\Transport\SmtpOption();


                $smtpOptions->setHost('smtp.gmail.com')
                            ->setConnectionClass('login')
                            ->setName('smtp.gmail.com')
                            ->setConnectionConfig(array(

                             'username' => 'youfslair@hotmail.com',
                              'password'=> 'kadi1978',
                              'ssl'     => 'tls'
                          ));

                $transport = new \Zend\Mail\Transport\Smtp($smtpOptions);
                $transport->send($message);

             }
            return array('from' => $form);




      }










 }






