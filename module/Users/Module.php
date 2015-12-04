<?php
namespace Users;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
 use Users\Model\User;
 use Users\Model\UserTable;
 use Zend\InputFilter\InputFilter;
 
 use Users\Model\Upload;
 use Users\Model\UploadTable;
 
 use Users\Model\ChatMessages;
 use Users\Model\ChatMessagesTable;
 
 use Users\Model\StoreProduct;
 use Users\Model\StoreProductTable;
 
 
 use Zend\Mvc\MvcEvent;
 use Zend\EventManager\EventManager;
 use Zend\Mvc\ModuleRouteListener;


 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\Authentication\AuthenticationService;
 use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;


 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
     
     
     public function getServiceConfig()
     {
       return array(
          'abstract_factories' => array(),
          'aliases' => array(),
          'factories' => array(
            
             // DB
          'UserTable' => function($sm) {
           $tableGateway = $sm->get('UserTableGateway');
            $table = new UserTable($tableGateway);
            $ChatMessagesTableGateway = $sm->get('ChatMessagesTableGateway');
            //$table =  new ChatMessagesTable( $ChatMessagesTableGateway);
              return $table;
                                      },
                                      
                                      
             'UploadTable' => function($sm) {
           $tableGateway = $sm->get('UploadTableGateway');
           $uploadSharingTableGateway = $sm->get('UploadSharingTableGateway');
            $table = new UploadTable($tableGateway, $uploadSharingTableGateway);
                   return $table;

                                      },
                                     
                                     /* 
                                       'ChatMessagesTable' => function($sm) {
           $tableGateway = $sm->get('ChatMessagesTableGateway');
           $ChatMessagesTableGateway = $sm->get('ChatMessagesTableGateway');
            $table = new ChatMessageTable($tableGateway, $ChatMessagesTableGateway);
                   return $table;

                                      },
                                      
                                      */
                                     /*
                                     'Users\Model\StoreProductTable' => function ($sm) {
                     return new \Users\Model\StoreProductTable('comm_app');
               },
                           */          
                                     'StoreProductTable' => function($sm) {
           $tableGateway = $sm->get('StoreProductTableGateway');
           $StoreProductTableGateway = $sm->get('StoreProductTableGateway');
            $table = new StoreProductTable($tableGateway, $StoreProductTableGateway);
                   return $table;

                                      },
                                      
                                      'StoreOrderTable' => function($sm) {
           $tableGateway = $sm->get('StoreProductTableGateway');
           $StoreOrderTableGateway = $sm->get('StoreOrderTableGateway');
            $table = new StoreOrderTable($tableGateway, $StoreOrderTableGateway);
                   return $table;

                                      },
                                      
                                      
                                    
                                    'Users\Model\UserTable' => function ($sm) {
                     return new \Users\Model\UseTable('comm_app');
               },
                                      
          'UserTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $resultSetPrototype = new ResultSet();
              $resultSetPrototype->setArrayObjectPrototype(new User());

          return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                      },
                      
                      'UploadTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $resultSetPrototype = new ResultSet();
              $resultSetPrototype->setArrayObjectPrototype(new Upload());

          return new TableGateway('upload', $dbAdapter, null, $resultSetPrototype);
                      },
                      
                      
             'UploadSharingTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
             return new TableGateway('uploads_sharing', $dbAdapter);
             },
          
          /*
             'ChatMessagesTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $resultSetPrototype = new ResultSet();
              $resultSetPrototype->setArrayObjectPrototype(new ChatMessages());

          return new TableGateway('chat_messages', $dbAdapter, null, $resultSetPrototype);
                      },         
                      */
          
          'ChatMessagesTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
             return new TableGateway('chat_messages', $dbAdapter);
             },
          
          
          'StoreProductTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
             return new TableGateway('store_products', $dbAdapter);
             },
             
             'StoreOrderTableGateway' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
             return new TableGateway('store_orders', $dbAdapter);
             },
          
                      
     'AuthService' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter,'user','email','password', 'MD5(?)');
              $authService = new AuthenticationService();
              $authService->setAdapter($dbTableAuthAdapter);
              $this->authservice = $authService;


          return $authService;
                      },
                      
      'AuthService' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter,'filename','label','user_id');
              $authService = new AuthenticationService();
              $authService->setAdapter($dbTableAuthAdapter);
              $this->authservice = $authService;


          return $authService;
                      },
    
    'AuthService' => function ($sm) {
              $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
              $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter,'store_products','name','desc','cost');
              $authService = new AuthenticationService();
              $authService->setAdapter($dbTableAuthAdapter);
              $this->authservice = $authService;


          return $authService;
        
                      },
         
    
                      
                    // FORMS
              'LoginForm' => function ($sm) {
                 $form = new \Users\Form\LoginForm();
                  $form->setInputFilter($sm->get('LoginFilter'));
                       return $form;
                       },
                'RegisterForm' => function ($sm) {
                      $form = new \Users\Form\RegisterForm();
                      $form->setInputFilter($sm->get('RegisterFilter'));
                       return $form;
                          },
                          
                'UploadForm' => function ($sm) {
                      $form = new \Users\Form\UploadForm();
                      $form->setInputFilter($sm->get('UploadFilter'));
                       return $form;
                          },
                 
                 'ContactForm' => function ($sm) {
                 $form = new \Users\Form\ContactForm();
                  $form->setInputFilter($sm->get('ContactFilter'));
                       return $form;
                       },
                 
                 
                         
                          
                          
                          'UserEditForm' => function ($sm) {
                      $form = new \Users\Form\UserEditForm();
                      $form->setInputFilter($sm->get('UserEditFilter'));
                       return $form;
                          },
                          
                          'UserAddForm' => function ($sm) {
                      $form = new \Users\Form\UserAddForm();
                      $form->setInputFilter($sm->get('UserAddFilter'));
                       return $form;
                          },
                          
                           'ProductEditForm' => function ($sm) {
                      $form = new \Users\Form\ProductEditForm();
                      $form->setInputFilter($sm->get('ProductEditFilter'));
                       return $form;
                          },
                          
                          
                   // FILTERS
                'LoginFilter' => function ($sm) {
                    return new \Users\Form\LoginFilter();
                           },
                'RegisterFilter' => function ($sm) {
                    return new \Users\Form\RegisterFilter();
                            },
                            
                'UploadFilter' => function ($sm) {
                    return new \Users\Form\RegisterFilter();
                            },
                            
                'ContactFilter' => function ($sm) {
                    return new \Users\Form\ContactFilter();
                           },            
                            
                            'UserEditFilter' => function ($sm) {
                    return new \Users\Form\UserEditFilter();
                            },
                            'UserAddFilter' => function ($sm) {
                    return new \Users\Form\UserAddFilter();
                            },
                            
                            'ProductEditFilter' => function ($sm) {
                    return new \Users\Form\ProductEditFilter();
                            },
                            
                            
                            
                                  ),
                          'invokables' => array(),
                          'services' => array(),
                          'shared' => array(),
                                           );
         }
         
         
             public function getFileUploadLocation()
         {
             // Fetch Configuration from Module Config
             $config = $this->getServiceLocator()->get('config');
             return $config['module_config']['upload_location'];
           }

         /*
       public function onBootstrap($e)
    {
      $eventManager = $e->getApplication()->getEventManager();
      $moduleRouteListener = new ModuleRouteListener();
      $moduleRouteListener->attach($eventManager);
      $sharedEventManager = $eventManager->getSharedManager(); // The shared event manager
      $sharedEventManager->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function($e) {
      $controller = $e->getTarget(); // The controller which is dispatched
      $controllerName = $controller->getEvent()->getRouteMatch()->getParam('controller');
       if (!in_array($controllerName,
         array('Users\Controller\Index', 'Users\Controller\Register', 'Users\Controller\Login'))) {
       $controller->layout('layout/myaccount');
                 }
           } );
      }
  
       */  
         
         

     
     
 }