<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;
use Application\Model\User;
use Application\Model\UserTable;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'user' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/user[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                        ],
                    ],
                ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\UserController::class => \Application\Controller\Factory\UserControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Application\Model\UserTable::class => function($container) {
                $tableGateway = $container->get('UserTableGateway');
                return new \Application\Model\UserTable($tableGateway);
            },
            'UserTableGateway' => function ($container) {
                $dbAdapter = $container->get('Laminas\Db\Adapter\Adapter');
                $resultSetPrototype = new \Laminas\Db\ResultSet\ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new \Application\Model\User());
                return new \Laminas\Db\TableGateway\TableGateway('users', $dbAdapter, null, $resultSetPrototype);
            },
    ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
