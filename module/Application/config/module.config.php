<?php

namespace Application;

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'produto' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/produto[/:action[/pagina/:page][/:key][/:slug]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]*',
                        'key' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Produto',
                        'action' => 'index',
                        'page' => '1',
                    ),
                ),
            ),
            'turma' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/turma[/:action[/pagina/:page][/:key][/:slug]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]*',
                        'key' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Turma',
                        'action' => 'index',
                        'page' => '1',
                    ),
                ),
            ),
            'tipoServico' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/tipoServico[/:action[/pagina/:page][/:key][/:slug]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]*',
                        'key' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'TipoServico',
                        'action' => 'index',
                        'page' => '1',
                    ),
                ),
            ),
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller][/:action][/:hash]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    //rota ver fale conosco.
                    'atualizaPonto' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/atualizaPonto',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Index',
                                'action' => 'atualizaPonto',
                            ),
                        ),
                    ),
                    'atualizaListaFechamentoBolsista' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/atualizaListaFechamentoBolsista',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Index',
                                'action' => 'atualizaListaFechamentoBolsista',
                            ),
                        ),
                    ),
                    'auth' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/auth[/:action][/:hash]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Auth',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'validarDocumento' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/validarDocumento[/:action][/:hash]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Auth',
                                'action' => 'validarDocumento',
                            ),
                        ),
                    ),
                    'usuario' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/usuario[/:action[/pagina/:page][/:key][/:slug]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '[0-9]*',
                                'key' => '[0-9]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Usuario',
                                'action' => 'index',
                                'page' => '1',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
    ),
    'translator' => array(
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\AuthController',
            'Application\Controller\Cron' => 'Application\Controller\CronController',
            'Application\Controller\Auth' => 'Application\Controller\AuthController',
            'Application\Controller\Turma' => 'Application\Controller\TurmaController',
            'Application\Controller\TipoServico' => 'Application\Controller\TipoServicoController',
            'Application\Controller\Produto' => 'Application\Controller\ProdutoController',
        ),
    ),
    'module_layouts' => array(
        'Application' => 'layout/admin.phtml',
        'Usuario' => 'layout/admin.phtml',
        'Comunicacao' => 'layout/admin.phtml',
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/admin.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Doctrine
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
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
/*teste*/