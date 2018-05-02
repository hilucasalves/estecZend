<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */ 
return array(
    'doctrine_config' => array(
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => '12345',
        'dbname' => 'estec2',
        'charset' => 'utf8',
        'driverOptions' => array(
            1002 => 'SET NAMES utf8'
        )
    ),
    
    'service_manager' => array(
         'factories' => array(
             'Zend\Db\Adapter\Adapter'
                     => 'Zend\Db\Adapter\AdapterServiceFactory',
         ),
        
      
    ),
);
