<?php

namespace Upload;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface, ServiceProviderInterface, FormElementProviderInterface
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
                'Upload\Options\ModuleOptions' => 'Upload\Factory\ModuleOptionsFactory',
                'Upload\Adapter\Http' => 'Upload\Factory\HttpFactory',
            )
        );
    }

    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'SubjectSelect' => 'Upload\Form\Factory\SubjectSelectFactory',
                'CategorySelect' => 'Upload\Form\Factory\CategorySelectFactory',
            ),
        );
    }
}
