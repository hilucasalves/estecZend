<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class UsuarioPermissao extends AbstractHelper implements \Zend\ServiceManager\ServiceLocatorAwareInterface
{

    public function getServiceLocator()
    {
        return $this->services;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->services = $serviceLocator;
    }

    public function __invoke($usuarioTipo, $controller, $action, $namespace = null)
    {
        $acl = $this->getServiceLocator()->get('Usuario\Permissoes\Acl');
        $permissao = $acl->isAllowed($usuarioTipo, $controller, $action) ? true : false;

        return $permissao;
    }

}
