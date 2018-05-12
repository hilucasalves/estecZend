<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

class UsuarioAutenticado extends AbstractHelper {

    protected $authService;

    public function getAuthService() {

        return $this->authService;
    }

    public function __invoke($namespace = null) {
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
