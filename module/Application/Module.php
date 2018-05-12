<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\I18n\Translator\Translator;
use Zend\Validator\AbstractValidator;
use Application\Auth\DoctrineAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // Mensagens
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace]))
            {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }
                , 100);

        // Autenticação
        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(
                'Zend\Mvc\Controller\AbstractActionController', MvcEvent::EVENT_DISPATCH, array($this, 'validaAuth'), 1000
        );

        //Cria o translator
        $translator = new \Zend\Mvc\I18n\Translator(new \Zend\I18n\Translator\Translator());

        //Adiciona o arquivo de tradução
        $translator->addTranslationFile(
                'phpArray', __DIR__ . '/../../vendor/zendframework/zendframework/resources/languages/pt_BR/Zend_Validate.php', 'default', 'pt_BR'
        );

        //Define o tradutor padrão dos validadores
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }

    public function validaAuth($event)
    {
        $di = $event->getTarget()->getServiceLocator();

        $auth = new AuthenticationService;
        $auth->setStorage(new Session('usuario'));

        $routeMatch = $event->getRouteMatch();

        $route = explode('\\', $routeMatch->getParam('controller'));

        $module = $route[0];
        $controller = $route[2];
        $action = $routeMatch->getParam('action');

        $em = $GLOBALS['entityManager'];


        if ("Application" != $module)
        {
            if (!$auth->hasIdentity())
            {
                return $event->getTarget()->redirect()->toRoute('application/auth');
            } else
            {
                $perfis = $em->getRepository('Application\Entity\Usuario')->findOneBy(array('email' => $auth->getIdentity()->__get('email')));
                $acl = $di->get('Usuario\Permissoes\Acl');
                $permitido = $acl->isAllowed($perfis->usuarioTipo->nome, $controller, $action) ? 1 : 0;

                if (0 == $permitido)
                {

                    return $event->getTarget()->redirect()->toRoute('usuario/default', array('action' => 'acesso-negado'));
                }
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'flashMessages' => function($sm) {
            $flashmessenger = $sm->getServiceLocator()
                    ->get('ControllerPluginManager')
                    ->get('flashmessenger');

            $messages = new \Uaitec\Helper\FlashMessages();
            $messages->setFlashMessenger($flashmessenger);

            return $messages;
        },
            ),
            'invokables' => array(
                'usuarioAutenticado' => new View\Helper\UsuarioAutenticado(),
                'usuarioPermissao' => new View\Helper\UsuarioPermissao()
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Application\Auth\DoctrineAdpter' => function($sm) {
            return new DoctrineAdapter();
        },
                'Usuario\Permissoes\Acl' => function($sm) {
            $em = $GLOBALS['entityManager'];
            $perfis = $em->getRepository('Usuario\Entity\UsuarioTipo')->findAll();
            $recursos = $em->getRepository('Usuario\Entity\PerfilControle')->findAll();
            $permissoes = $em->getRepository('Usuario\Entity\PerfilPermissao')->findAll();

            return new \Usuario\Permissoes\Acl($perfis, $recursos, $permissoes);
        }
            )
        );
    }

}
