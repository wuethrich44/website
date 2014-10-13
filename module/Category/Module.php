<?php

namespace Category;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface, ServiceProviderInterface
{

    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__.'/src/'.
                    __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Category\Model\Category' => 'Category\Model\Factory\CategoryFactory',
                'Category\Model\CategoryTable' => 'Category\Model\Factory\CategoryTableFactory',
                'Category\Model\ResultSet' => 'Category\Model\Factory\ResultSetFactory',
                'Category\Model\TableGateway' => 'Category\Model\Factory\TableGatewayFactory',
            )
        );
    }
}
