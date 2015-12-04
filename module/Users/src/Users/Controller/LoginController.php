<?php
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginForm;
use Zend\InputFilter\InputFilter;
use Users\Form\LoginFilter;
use Users\Model\User;
use Users\Model\UserTable;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;



class LoginController extends AbstractActionController
{
    #Attributs
    protected $authservice;
    
    #Constantes
    
    
    
    #Methodes 
    
    
         public function indexAction()
       {
          // $form = new LoginForm();
          
          $form = $this->getServiceLocator()->get('LoginForm');

           $viewModel = new ViewModel(array('form' => $form));
            return $viewModel;
        }
        
    
    
        public function getAuthService()
         {
            if (!$this->authservice) {
                  
                   
          $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
              
              //$dbAdapter = $this->getServiceLocator()->get('UserTableGateway');
              
           $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter,'user','email','password', 'MD5(?)');
           $authService = new AuthenticationService();
           //utilisation du sm
           $authService = $this->getServiceLocator()->get('authService');
           //$arrUserDetails     =   $authservice->getIdentity();
           $authService->setAdapter($dbTableAuthAdapter);
           
           $this->authservice = $authService;
           
          // $this->authservice = $this->getServiceLocator()->get('AuthService');
                 
                  //return $this->getServiceLocator()->get('AuthService');
                  
                                }
             return $this->authservice;
        }
        
        
        public function processAction()
      {
        if (! $this->request->isPost()) {
         return $this->redirect()->toRoute(NULL ,
         array( 'controller' => 'login',
                   'action' => 'index'
              )
        //$form = $this->getServiceLocator()->get('LoginForm')
                                         );
            }
                    
                     // lorsqu'il un post 
     $this->getAuthService()
          ->getAdapter()
          ->setIdentity($this->request->getPost('email'))
          ->setCredential($this->request->getPost('password'));
      
         $result = $this->getAuthService()->authenticate();
          
            if ($result->isValid()) {
                           $this->getAuthService()->getStorage()->write($this->request->getPost('email'));
                             return $this->redirect()->toRoute(NULL , array(
                                              'controller' => 'login',
                                                 'action' => 'confirm'
                                                          ));

               
        }
    }

        
        public function confirmAction()
        {
              $user_email = $this->getAuthService()->getStorage()->read();
               $viewModel = new ViewModel(array(
              'user_email' => $user_email
               ));
                return $viewModel;
         }

        
/*
        public function getLoggedInUser()
        {
          $user = $this->getAuthService()->getStorage()->read();
         $viewModel = new ViewModel(array(
                'user' => $user                          
                                          
                                          )); 
         return $viewModel;
         
        }

     */  
}


