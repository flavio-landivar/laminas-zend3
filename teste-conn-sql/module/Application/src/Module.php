<?php

declare(strict_types=1);

namespace Application;

//use Laminas\EventManager\EventInterface;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Mvc\MvcEvent;
use Laminas\ServiceManager\ServiceManager;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function onBootstrap(MvcEvent $e) {
        
        /** 
         * @var serviceManager Laminas\ServiceManager\ServiceManager 
         * @var $adapter       Adapter
         */
        $serviceManager = $e->getApplication()->getServiceManager();
        $adapter = $serviceManager->get(Adapter::class);

        $statement = $adapter->createStatement("SELECT * FROM users");
        $statement->prepare();

        $result = $statement->execute();

        if($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet();
            $resultSet->initialize($result);

            foreach($resultSet as $row) {
                echo $row->id . PHP_EOL;
                echo $row->name . PHP_EOL;
                echo $row->email . PHP_EOL;
            }
        }

        die;
    }
}
