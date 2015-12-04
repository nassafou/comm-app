<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginForm;
use Users\Model\User;
use Users\Model\UserTable;

use Users\Model\Upload;
use Users\Model\UploadTable;

use Users\Model\ChatMessages;
use Users\Model\ChatMessagesTable;

use Users\Model\StoreProduct;
use Users\Model\StoreProductTable;

use Zend\Mail;
use Zend\Mail\Transport\Sendmail;


use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;



class StoreController extends AbstractActionController
{
    #Attributs
    protected $authservice;
    
    #Constantes
    
    
    
    #Methodes 
    
    
    
    
         public function indexAction()
       {
          $StoreProductTable = $this->getServiceLocator()->get('StoreProductTable');
           $viewModel = new ViewModel(array(
            'products1' => $StoreProductTable->fetchAll()));
             return $viewModel;

         
          
        }
        
        
        public function productDetailAction()
        {
         /*
         $product_cost = $this->getAuthService()->getStorage()->read();
               $viewModel = new ViewModel(array(
              'procduct_cost' => $product_cost
               ));
                return $viewModel;
                */
         
         $StoreProductTable = $this->getServiceLocator()->get('StoreProductTable');
               $store_products = $StoreProductTable->getStoreProduct(
               $this->params()->fromRoute('id'));
               $form = $this->getServiceLocator()->get('ProductEditForm');
               $form->bind($store_products);
               //var_dump($store_products);
          $viewModel = new ViewModel(array(
            
              'store_product1' => $StoreProductTable->getStoreProduct(
               $this->params()->fromRoute('id')),
            
               'form' => $form,
               
              'store_product_id' => $this->params()->fromRoute('id')
            
              
              
                              ));
                 return $viewModel;
           
        }
        
        public function shoppingCartAction()
        {
            
        }
        
        public function paypalExpressCheckoutAction()
        {
            
        }
        
        public function paymentConfirmAction()
        {
            
        }
        public function paymentCancelAction()
        {
            
        }
        
        
        
         public function processAction()
      {
        if ( $this->request->isPost()) {
         return $this->redirect()->toRoute(NULL ,
         array( 'controller' => 'store',
                   'action' => 'index'
              )
        //$form = $this->getServiceLocator()->get('LoginForm')
                                         );
            }
                    
                     // lorsqu'il un post 
     $this->getAuthService()
          ->getAdapter()
          ->setIdentity($this->request->getPost('name'))
          ->setCredential($this->request->getPost('desc'));
      
         $result = $this->getAuthService()->authenticate();
          
            if ($result->isValid()) {
                           $this->getAuthService()->getStorage()->write($this->request->getPost('cost'));
                             return $this->redirect()->toRoute(NULL , array(
                                              'controller' => 'store',
                                                 'action' => 'productDetail'
                                                          ));

               
        }
    }
        
        
        public function messageListAction()
       {
            $userTable = $this->getServiceLocator()->get('StoreProductTable');
            $chatMessageTG = $this->getServiceLocator()->get('StoreProductTableGateway');
            $chatMessages = $chatMessageTG->select();
            $messageList = array();
            foreach($chatMessages as $chatMessage) {
            $fromUser = $userTable->getUser($chatMessage->user_id);
            $messageData = array();
            $messageData['user'] = $fromUser->name;
            $messageData['time'] = $chatMessage->stamp;
            $messageData['data'] = $chatMessage->message;
            $messageList[] = $messageData;
                  }
            $viewModel = new ViewModel(array('messageList' => $messageList));
            $viewModel->setTemplate('users/group-chat/message-list');
            $viewModel->setTerminal(true);
                  return $viewModel;
        }

      
          
         protected function sendMessage($messageTest , $fromUserId)
         {
               $chatMessageTG = $this->getServiceLocator()->get('ChatMessagesTableGateway');
               $data = array(
               'user_id' => $fromUserId,
               'message' => $messageTest,
                 'stamp' => NULL
                      );
               $chatMessageTG->insert($data);
               return true;
          }
  
   /*
         protected function getLoggedInUser()
         {
            //$userTable = $this->getServiceLocator()->get('UserTable');
            //$user = $this->getServiceLocator()->getUser();
            
           // $user = $userTable->getUser($chatMessage->user_id);
           $post = $this->request()->getPost();
            $usertable = $this->getServiceLocator()->get('UserTable');
            $user = $usertable->getUser($post->id);
            
            return $user;
            
         }
   
      */
   
   public function getLoggedInUser()
        {
         $authService = $this->getServiceLocator()->get('authService');
          $user = $this->getAuthService()->getStorage()->read();
         $viewModel = new ViewModel(array(
                'user' => $user                          
                                          
                                          )); 
         return $viewModel;
        }
        
        /*
        
        public function getAuthService()
         {
            if (!$this->authservice) {
          $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
              
              //$dbAdapter = $this->getServiceLocator()->get('UserTableGateway');
              
           $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter,'user','email','password', 'MD5(?)');
           $authService = new AuthenticationService();
           //utilisation du sm
          // $authService = $this->getServiceLocator()->get('authService');
           //$arrUserDetails     =   $authservice->getIdentity();
           $authService->setAdapter($dbTableAuthAdapter);
           
           $this->authservice = $authService;
           
          // $this->authservice = $this->getServiceLocator()->get('AuthService');
           
                                }
             return $this->authservice;
        }
        */
        
        public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }
        
        return $this->authservice;
    }
        
      
        
        
        
        protected function sendOfflineMessage($msgSubj, $msgText, $fromUserId, $toUserId)
     {
            $userTable = $this->getServiceLocator()
                              ->get('UserTable');
            $fromUser = $userTable->getUser($fromUserId);
            $toUser = $userTable->getUser($toUserId);
            $mail = new Mail\Message();
            $mail->setFrom($fromUser->email, $fromUser->name);
            $mail->addTo($toUser->email, $toUser->name);
            $mail->setSubject($msgSubj);
            $mail->setBody($msgText);
            $transport = new Mail\Transport\Sendmail();
            $transport->send($mail);
            return true;
}

        
        
        
        
        
        
}
      




