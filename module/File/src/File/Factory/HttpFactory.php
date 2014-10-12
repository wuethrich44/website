<?php

namespace File\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Zend\Filter\File\Rename;
use Zend\File\Transfer\Adapter\Http;

class HttpFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('File\Options\ModuleOptions');

        $size      = new Size(array('max' => $options->getMaxFileSizeInByte()));
        $extension = new Extension($options->getAllowedFileExtensions());

        if ($options->getRandomizeFileName()) {
            $rename = new Rename(array(
                'target' => $options->getUploadFolderPath().'/file',
                'randomize' => true,
            ));
        } else {
            $rename = null;
        }

        $adapter = new Http();
        $adapter->setValidators(array($size, $extension));
        $adapter->setFilters(array($rename));

        return $adapter;
    }
}
