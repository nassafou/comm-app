<?php
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginForm;
use Users\Model\User;
use Users\Model\UserTable;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;



class UserManagerController extends AbstractActionController
{
    #Attributs
    
    
    #Constantes
    
    
    
    #Methodes 
    
    
         public function indexAction()
       {
          $userTable = $this->getServiceLocator()->get('UserTable');
           $viewModel = new ViewModel(array(
            'users' => $userTable->fetchAll()));
             return $viewModel;

          
        }
       
       /*
        *@param Add
        *
        */
       
             public function addAction()
      {
        if (!$this->request->isPost()) {
         return $this->redirect()->toRoute(NULL ,
         array( 'controller' => 'user-manager',
                   'action' => 'add'
              ));
            }
            $post = $this->request->getPost();
            $form = new RegisterForm();
            // to get Login Form
           $form = $this->getServiceLocator()->get('LoginForm');

            
            $inputFilter = new RegisterFilter();
            $form->setInputFilter($inputFilter);
            $form->setData($post);
                if (!$form->isValid()) {
                      $model = new ViewModel(array(
                        'error' => true,
                         'form' => $form,
                               ));

             $model->setTemplate('users/user-manager/add');
                             return $model;
                     }
                     
                     // Créer l'utisateur avant la page de  confirmation  
                      $this->createUser($form->getData());

                       return $this->redirect()->toRoute(NULL , array(
                       'controller' => 'register',
                           'action' => 'confirm'
                 ));
        }

       
       
       
        
        /*@param Eddit
         *
         *
         */
        
        public function editAction()
       {
          $userTable = $this->getServiceLocator()->get('UserTable');
               $user = $userTable->getUser(
               $this->params()->fromRoute('id'));
               $form = $this->getServiceLocator()->get('UserEditForm');
               $form->bind($user);
          $viewModel = new ViewModel(array(
               'form' => $form,
              'user_id' => $this->params()->fromRoute('id')
                              ));
                 return $viewModel;

        }
        
         
          public function processAction()
       {
          
          // Obtenez ID de l'utilisateur à partir des l'envoie
           $post = $this->request->getPost();
          $userTable = $this->getServiceLocator()->get('UserTable');
          
          
           // Charger l'entité Utilisateur
           $user = $userTable->getUser($post->id);
           
           
           
        // Bind User entity to Form Ratacher l'entité utilisateur  au formulaire
         $form = $this->getServiceLocator()->get('UserEditForm');
          $form->bind($user);	
          $form->setData($post);
          
          
          
         // Sauvegarder l'utilisateur
         $this->getServiceLocator()->get('UserTable')->saveUser($user);

        }  
        
        
        public function deleteAction()
       {
          $this->getServiceLocator()->get('UserTable')
               ->deleteUser($this->params()
               ->fromRoute('id'));


          
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
       
        
}