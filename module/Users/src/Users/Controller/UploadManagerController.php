<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginForm;
use Users\Model\User;
use Users\Model\UserTable;

use Users\Model\Upload;
use Users\Model\UploadTable;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;



class UploadManagerController extends AbstractActionController
{
    #Attributs
    
    
    #Constantes
    
    
    
    #Methodes 
    
    
         public function indexAction()
       {
          $uploadTable = $this->getServiceLocator()->get('UploadTable');
              $userTable = $this->getServiceLocator()->get('UserTable');
                    // Get User Info from Session
               $userEmail = $this->getAuthService()->getStorage()->read();
                  $user = $userTable->getUserByEmail($userEmail);
                $viewModel = new ViewModel( array(
              'myUploads' => $uploadTable->getUploadsByUserId($user->id),
                               ));
                     return $viewModel;

          
        }
        
        
        
      public function editAction()
      {
         
         $userTable = $this->getServiceLocator()->get('UserTable');
         $uploadTable = $this->getServiceLocator()->get('UploadTable');
         $form = $this->getServiceLocator()->get('UploadForm');
         $request = $this->getRequest();
         if ($request->isPost()) {
            $userId = $request->getPost()->get('user_id');
            $uploadId = $request->getPost()->get('upload_id');
            $uploadTable->addSharing($uploadId, $userId);
                   }
       }
       
       
       
       public function fileDownloadAction()
       {
           $uploadId = $this->params()->fromRoute('id');
           $uploadTable = $this->getServiceLocator()->get('UploadTable');
          
           $upload = $uploadTable->getUpload($uploadId);
          // Fetch Configuration from Module Config
           $uploadPath= $this->getFileUploadLocation();
           $file = file_get_contents($uploadPath ."/" . $upload->filename);
          // Directly return the Response
           $response = $this->getEvent()->getResponse();
           $response->getHeaders()->addHeaders(array(
                       'Content-Type' => 'application/octet-stream',
                       'Content-Disposition' => 'attachment;filename="'.$upload->filename . '"',
                   ));
            $response->setContent($file);
            return $response;
           }

          
          
           
        
        
}