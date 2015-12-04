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

use Zend\Mail;
use Zend\Mail\Transport\Sendmail;


use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;



class GroupChatController extends AbstractActionController
{
    #Attributs
    protected $authservice;
    
    #Constantes
    
    
    
    #Methodes 
    
    
         public function indexAction()
       {
          $user = $this->getLoggedInUser();	
          $request = $this->getRequest();
            if ($request->isPost()) {
          $messageTest = $request->getPost()->get('message');
          $fromUserId = $user->id;
          $this->sendMessage($messageTest, $fromUserId);
          // to prevent duplicate entries on refresh
          return $this->redirect()->toRoute('users/group-chat');
            }
            
            //Prepare Send Message Form
           $form = new \Zend\Form\Form();
              $form->add(array(
                     'name' => 'message',
               'attributes' => array(
                     'type' => 'text',
                       'id' => 'messageText',
                 'required' => 'required'
                          ),
                  'options' => array(
                    'label' => 'Message',
                         ),
                     ));
                  $form->add(array(
                     'name' => 'submit',
               'attributes' => array(
                     'type' => 'submit',
                    'value' => 'Send'
                        ),
                     ));
                 $form->add(array(
                     'name' => 'refresh',
               'attributes' => array(
                     'type' => 'button',
                       'id' => 'btnRefresh',
                    'value' => 'Refresh'
                              ),
                           ));
             $viewModel= new ViewModel(array('form' => $form,
                 'userName' => $user->name));
                    return $viewModel;
  
         
          
        }
        
        
        public function messageListAction()
       {
            $userTable = $this->getServiceLocator()->get('UserTable');
            $chatMessageTG = $this->getServiceLocator()->get('ChatMessagesTableGateway');
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
      