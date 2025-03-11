<?php

namespace Application\Controller\Factory;

use Application\Model\UserTable;
use Psr\Container\ContainerInterface;

class UserControllerFactory
{
    public function __invoke(ContainerInterface $container)
    { 
        $userTable = $container->get(UserTable::class);
        return new \Application\Controller\UserController($userTable);
    }
}
