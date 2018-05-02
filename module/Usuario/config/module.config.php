<?php

namespace Usuario;

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'usuario' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/usuario',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Usuario\Controller',
                        'controller' => 'Usuario',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/:controller[/:action[/pagina/:page][/:key]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '[0-9]*',
                                'key' => '[0-9]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Usuario\Controller',
                                'controller' => 'usuario',
                                'action' => 'index',
                                'page' => '1',
                            ),
                        ),
                    ),
                    'pagina' => array(
                        'type' => 'Segment',
                        'priority' => 10000,
                        'options' => array(
                            'route' => '/:controller/pagina[/:page]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '[0-9]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Usuario\Controller',
                                'controller' => 'Usuario',
                                'action' => 'index',
                                'page' => '1',
                            ),
                        ),
                    ),
                ),
            ),           
            'usuarioLogin' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuarioLogin[/:action[/pagina/:page][/:key]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]*',
                        'key' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Usuario\Controller',
                        'controller' => 'usuarioLogin',
                        'action' => 'index',
                        'page' => '1',
                    ),
                ),
            ),
            'usuarioTipo' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuarioTipo[/:action[/pagina/:page][/:key]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]*',
                        'key' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Usuario\Controller',
                        'controller' => 'UsuarioTipo',
                        'action' => 'index',
                        'page' => '1',
                    ),
                ),
            ),
            'usuarioPerfil' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuarioPerfil[/:action[/pagina/:page][/:key]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]*',
                        'key' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Usuario\Controller',
                        'controller' => 'Perfil',
                        'action' => 'index',
                        'page' => '1',
                    ),
                ),
            ),
            'usuarioPermissao' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuarioPermissao[/:action[/pagina/:page][/:key]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]*',
                        'key' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Usuario\Controller',
                        'controller' => 'PerfilPermissao',
                        'action' => 'index',
                        'page' => '1',
                    ),
                ),
            ),
        ),
    ),
    'documentos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/documentos[/:action[/pagina/:page][/:key]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]*',
                        'key' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Usuario\Controller',
                        'controller' => 'Documentos',
                        'action' => 'index',
                        'page' => '1',
                    ),
                ),
            ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Usuario\Controller\Usuario' => 'Usuario\Controller\UsuarioController',
            'Usuario\Controller\UsuarioLogin' => 'Usuario\Controller\UsuarioLoginController',
            'Usuario\Controller\UsuarioEscolaridade' => 'Usuario\Controller\UsuarioEscolaridadeController',
            'Usuario\Controller\UsuarioTipo' => 'Usuario\Controller\UsuarioTipoController',
            'Usuario\Controller\Perfil' => 'Usuario\Controller\PerfilController',
            'Usuario\Controller\PerfilPermissao' => 'Usuario\Controller\PerfilPermissaoController',
            'Usuario\Controller\Documentos' => 'Usuario\Controller\DocumentosController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/usuario/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    // Doctrine
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);
