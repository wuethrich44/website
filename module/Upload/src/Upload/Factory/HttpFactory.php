<?php

namespace Upload\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Upload\Adapter\Http;

class HttpFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('Upload\Options\ModuleOptions');

        return new Http($options);
    }
}
