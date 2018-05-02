<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Permissions\Acl\Acl;

class UsuarioPermissao extends AbstractHelper
{

    public function __invoke($usuarioTipo, $controller, $action, $namespace = null)
    {
        $sm = $this->getView()->getHelperPluginManager()->getServiceLocator();
        $acl = $sm->get('Usuario\Permissoes\Acl');
        $permissao = $acl->isAllowed($usuarioTipo, ucfirst($controller), $action) ? true : false;

        return $permissao;
    }

}
