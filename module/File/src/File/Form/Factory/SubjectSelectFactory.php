<?php

namespace File\Form\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use File\Form\Element\SubjectSelect;

class SubjectSelectFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $subjectTable = $serviceLocator->getServiceLocator()->get('Subject\Model\SubjectTable');

        return new SubjectSelect($subjectTable);
    }
}
