<?php

namespace File;

use Zend\ModuleManager\Feature\FormElementProviderInterface;

class Module implements FormElementProviderInterface {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' .
                    __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig() {
        return array(
            'invokables' => array(
                'File\Model\File' => 'File\Model\File'
            ),
            'factories' => array(
                'File\Options\ModuleOptions' => 'File\Factory\ModuleOptionsFactory',
                'File\Adapter\Http' => 'File\Factory\HttpFactory',
                'File\Model\FileTable' => 'File\Model\Factory\FileTableFactory',
                'File\Model\ResultSet' => 'File\Model\Factory\ResultSetFactory',
                'File\Model\TableGateway' => 'File\Model\Factory\TableGatewayFactory',
            )
        );
    }

    public function getFormElementConfig() {
        return array(
            'factories' => array(
                'SubjectSelect' => 'File\Form\Factory\SubjectSelectFactory',
                'CategorySelect' => 'File\Form\Factory\CategorySelectFactory',
            ),
        );
    }
}
