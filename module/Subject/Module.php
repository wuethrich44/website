<?php

namespace Subject;

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
                'Subject\Model\Subject' => 'Subject\Model\Factory\SubjectFactory',
                'Subject\Model\SubjectTable' => 'Subject\Model\Factory\SubjectTableFactory',
                'Subject\Model\ResultSet' => 'Subject\Model\Factory\ResultSetFactory',
                'Subject\Model\TableGateway' => 'Subject\Model\Factory\TableGatewayFactory',
            )
        );
    }
}
