<?php
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\RegisterForm;
use Users\Form\RegisterFilter;
use Users\Model\User;
use Users\Model\UserTable;
use Users\Form\LoginForm;
use Zend\Form\Element\File;

use Users\Form\UploadForm;
use Users\Form\UploadFilter;
use Users\Model\Upload;
use Users\Model\UploadTable;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;



class UploadController extends AbstractActionController
{
    #Attributs
    
    
    
    
    #Constantes
    
    
    
    #Methodes 
    
     public function indexAction()
       {
           $form = new UploadForm();
           
           
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
         array( 'controller' => 'upload',
                   'action' => 'index'
              ));
            }
            //$post = $this->request->getPost();
			
			//$request = $this->getRequest();
			
			//Création du formulaire 
            $form = new UploadForm();
			
			//récupération de l'objet de travail
			//$uploadFile = new File();
			
            $uploadFile = $this->params()->fromFiles('fileupload');
            $form->setData($this->$request->getPost());
            if ($form->isValid()) {
              // Fetch Configuration from Module Config
                $uploadPath = $this->getFileUploadLocation();
                   // Save Uploaded file
	
            $adapter = new \Zend\File\Transfer\Adapter\Http();
            $adapter->setDestination($uploadPath);
            if ($adapter->receive($uploadFile['name'])) {
                // File upload sucessfull
            $exchange_data = array();
            $exchange_data['label'] = $request->getPost()->get('label');
            $exchange_data['filename'] = $uploadFile['name'];
            $exchange_data['user_id'] = $user->id;
            $upload->exchangeArray($exchange_data);
            $uploadTable = $this->getServiceLocator()->get('UploadTable');
            $uploadTable->saveUpload($upload);
            return $this->redirect()->toRoute('users/upload-manager' ,
            array('action' => 'index'
             ));
            }

            /*
            $post = $this->request->getPost();
            $form = new UploadForm();
            // to get Login Form
          // $form = $this->getServiceLocator()->get('LoginForm');

            
            $inputFilter = new UploadFilter();
            $form->setInputFilter($inputFilter);
            $form->setData($post);
                if (!$form->isValid()) {
                      $model = new ViewModel(array(
                        'error' => true,
                         'form' => $form,
                               ));

             $model->setTemplate('users/upload/index');
                             return $model;
                     }
                     
                     // Créer l'utisateur avant la page de  confirmation  
                      $this->createUpload($form->getData());

                       return $this->redirect()->toRoute(NULL , array(
                       'controller' => 'upload',
                           'action' => 'confirm'
                 ));
                    */
        }
      }
        
        
        //la fonction utilise UserTable pour sauvegarder les enregistrements dans la bases
        
        protected function createUpload(array $data)
        {
                $sm = $this->getServiceLocator();
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new \Users\Model\Upload);
                $tableGateway = new \Zend\Db\TableGateway\TableGateway('upload', $dbAdapter, null, $resultSetPrototype);
                            $upload = new Upload();
                            $upload->exchangeArray($data);
                            $uploadTable = new UploadTable($tableGateway);
                            $uploadTable = $this->getServiceLocator()->get('UploadTable');

                            $uploadTable->saveUpload($upload);
                            return true;
         }

        




}