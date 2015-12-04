<?php
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\ContactForm;
use Users\Form\ContactFilter;
use Users\Model\User;
use Users\Model\UserTable;


use Zend\Mail\Transport\Sendmail;
use Zend\Mail;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class ContactController extends AbstractActionController
{
    #Attributs
    
    
    
    
    #Constantes
    
    
    
    #Methodes 
    
     public function indexAction()
       {
           $form = new ContactForm();
           
           
           $viewModel = new ViewModel(array('form' => $form));
            return $viewModel;
        }
        
        
     public function confirmAction()
       {
           $viewModel = new ViewModel();
           return $viewModel;
        }
        
        
      public function processAction()
      {
        if (!$this->request->isPost()) {
         return $this->redirect()->toRoute(NULL ,
         array( 'controller' => 'contact',
                   'action' => 'index'
              ));
            }
            $post = $this->request->getPost();
            $form = new ContactForm();
            // to get Login Form
           $form = $this->getServiceLocator()->get('ContactForm');

            
            $inputFilter = new ContactFilter();
            $form->setInputFilter($inputFilter);
            $form->setData($post);
                if (!$form->isValid()) {
                      $model = new ViewModel(array(
                        'error' => true,
                         'form' => $form,
                               ));

             $model->setTemplate('users/contact/index');
                             return $model;
                     }
                     
                     // Créer l'utisateur avant la page de  confirmation  
                      $this->createMessage($form->getData());

                       return $this->redirect()->toRoute(NULL , array(
                       'controller' => 'contact',
                           'action' => 'confirm'
                 ));
        }
        
        
        //la fonction utilise UserTable pour sauvegarder les enregistrements dans la bases
        
        protected function createUser(array $data)
        {
                $sm = $this->getServiceLocator();
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new \Users\Model\User);
                $tableGateway = new \Zend\Db\TableGateway\TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                            $user = new User();
                            $user->exchangeArray($data);
                            $userTable = new UserTable($tableGateway);
                            $userTable = $this->getServiceLocator()->get('UserTable');

                            $userTable->saveUser($user);
                            return true;
         }

        
        protected function createMessage(array $data)
        {
          
          $message = new \Zend\Mail\Message();
                $message->setBody($_POST['message']);
                $message->setFrom($_POST['email']);
                $message->setSubject(" contact message ");
                $message->addTo('ntyoussouf@gmail.com');
               
                $smtpOptions = new \Zend\Mail\Transport\SmtpOptions();


                $smtpOptions->setHost('smtp.gmail.com')
                            ->setConnectionClass('login')
                            ->setName('smtp.gmail.com')
                            ->setConnectionConfig(array(

                             'username' => 'ntyoussouf@gmail.com',
                              'password'=> 'Yatakafils1',
                              'ssl'     => 'tls'
                          ));

                $transport = new \Zend\Mail\Transport\Smtp($smtpOptions);
                $transport->send($message);
          
          
          
        }




}