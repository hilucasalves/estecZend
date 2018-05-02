<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

class UsuarioAutenticado extends AbstractHelper
{

    protected $authService;

    public function getAuthService()
    {

        return $this->authService;
    }

    public function __invoke($namespace = null)
    {
        $sessionStorage = new Session('login');
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);

        if ($this->getAuthService()->hasIdentity())
        {
            $em = $GLOBALS['entityManager'];
            $usuario = $em->getRepository('Usuario\Entity\Usuario')->findOneBy(array('login' => $this->getAuthService()->getIdentity()->idLogin));

            return array(
                'nome' => $this->getAuthService()->getIdentity()->nome,
                'idLogin' => $this->getAuthService()->getIdentity()->idLogin,
                'usuario' => $usuario
            );
        } else
        {
            return false;
        }
    }

}
