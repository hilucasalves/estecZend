<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuario;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Usuario\View\Helper\FlashMessages;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

class Module {

    const DOCTRINE_BASE_PATH = '/../../vendor/doctrine/orm/lib/Doctrine';

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $GLOBALS['sm'] = $e->getApplication()->getServiceManager();

        $this->initializeDoctrine2($e);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(__DIR__ . '/autoload_classmap.php',),
            'Zend\Loader\StandardAutoloader' => array(
                    'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'Uaitec' => realpath(__DIR__ . '/../../vendor/uaitecframework/uaitecframework/library/Uaitec'),
                    'Doctrine\Common' => realpath(__DIR__ . self::DOCTRINE_BASE_PATH . '/Common'),
                    'Doctrine\DBAL' => realpath(__DIR__ . self::DOCTRINE_BASE_PATH . '/DBAL'),
                    'Doctrine\ORM' => realpath(__DIR__ . self::DOCTRINE_BASE_PATH . '/ORM'),
                    
                     
                ),
            ),
            
        );
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'flashMessages' => function($sm) {
            $flashmessenger = $sm->getServiceLocator()
                    ->get('ControllerPluginManager')
                    ->get('flashmessenger');

            $messages = new FlashMessages();
            $messages->setFlashMessenger($flashmessenger);

            return $messages;
        }
            ),
        );
    }

    private function initializeDoctrine2($e) {

        $conn = $this->getDoctrine2Config($e);
        $config = new Configuration();
        $cache = new ArrayCache();
        $config->setMetadataCacheImpl($cache);
        $annotationPath = realpath(__DIR__ . self::DOCTRINE_BASE_PATH . '/ORM/Mapping/Driver/DoctrineAnnotations.php');
        AnnotationRegistry::registerFile($annotationPath);
        $driver = new AnnotationDriver(
                new AnnotationReader(), array(__DIR__ . '/src/Usuario/Entity')
        );
        $config->setMetadataDriverImpl($driver);
        $config->setProxyDir(__DIR__ . '/src/Usuario/Proxy');
        $config->setProxyNamespace('Usuario\Proxy');
        $entityManager = EntityManager::create($conn, $config);
        $GLOBALS['entityManager'] = $entityManager;
    }

    private function getDoctrine2Config($e) {
        $config = $e->getApplication()->getConfig();
        return $config['doctrine_config'];
    }

}
