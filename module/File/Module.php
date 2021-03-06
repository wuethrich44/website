<?php

namespace File;

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
            'invokables' => array(
                'File\Model\File' => 'File\Model\File'
            ),
            'factories' => array(
                'File\Model\FileTable' => 'File\Model\Factory\FileTableFactory',
                'File\Model\ResultSet' => 'File\Model\Factory\ResultSetFactory',
                'File\Model\TableGateway' => 'File\Model\Factory\TableGatewayFactory',
            )
        );
    }
}
