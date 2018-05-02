<?php 

// config/autoload/doctrine_orm.local.php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'root',
                    'password' => '12345',
                    'dbname' => 'estec2',
                    'charset' => 'utf8',
                    'driverOptions' => array(
                        1002 => 'SET NAMES utf8'
                    )
                )
            ),
        ),
        'entitymanager' => array(
            'orm_default' => array(
                'connection' => 'orm_default',
                'configuration' => 'orm_default'
            )
        )
    )
);
