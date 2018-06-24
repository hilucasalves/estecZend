<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Application\Form\LoginForm;

class AuthController extends AbstractActionController {

    public function indexAction() {

        $form = new LoginForm();

        $resquest = $this->getRequest();

        $messages = '';

        if ($resquest->isPost()) {

            $form->setData($resquest->getPost());

            if ($form->isValid()) {

                //Criando o armazem para gravar sessão da autenticação
                $sessionStorage = new Session("usuario");
                $auth = new AuthenticationService;
                $auth->setStorage($sessionStorage);

                $authAdpter = $this->getServiceLocator()->get('Application\Auth\DoctrineAdpter');
                $authAdpter->setEmail($form->getData()['email']);
                $authAdpter->setSenha($form->getData()['senha']);

                $result = $auth->authenticate($authAdpter);

                if ($result->isValid()) {
                    $login = $auth->getIdentity();
                    $login = $login['usuario'];
                    $sessionStorage->write($login, null);
                    $time = 7200;
                    $sessionManager = new \Zend\Session\SessionManager();
                    $sessionManager->rememberMe($time);

                    return $this->redirect()->toRoute('turma', array('controller' => 'index'));
                } else {
                    $messages = "Email ou Senha ínválido(s).";
                }
            } else {
                $messages = "Email ou Senha incorreto(s).";
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'messages' => $messages
        ));
    }

    public function logoutAction() {
        $auth = new AuthenticationService;
        $auth->setStorage(new Session('usuario'));
        $auth->clearIdentity();

        return $this->redirect()->toRoute('home');
    }

    //Retorna usuario autenticado
    protected $authService;

    public function getAuthService() {
        return $this->authService;
    }

    public function usuarioAutenticado() {
        $sessionStorage = new Session('usuario');
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);

        if ($this->getAuthService()->hasIdentity()) {
            $em = $GLOBALS['entityManager'];
            $usuario = $em->getRepository('Application\Entity\Usuario')->findOneBy(array('email' => $this->getAuthService()->getIdentity()->email));

            return array(
                'usuario' => $usuario
            );
        } else {
            return false;
        }
    }

}
