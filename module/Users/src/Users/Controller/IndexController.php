<?php
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    //fonction affichant une vue vierge
    public function indexAction()
    {
        $view = new ViewModel();
       return $view;
    }
    
     // fonction affichant un nouveau enregistrement
     
    public function registerAction()
    {
      $view = new ViewModel();
      $view->setTemplate('users/index/new-user');
       return $view;
    }
    
     // fonction affichant l'acces d'un nouveau utilisateur 
    public function loginAction()
    {
       $view = new ViewModel();
       $view->setTemplate('users/index/login');
        return $view;
     }
}