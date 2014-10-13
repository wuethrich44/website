<?php

namespace Upload\Form\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Upload\Form\Element\SubjectSelect;

class SubjectSelectFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $subjectTable = $serviceLocator->getServiceLocator()->get('Subject\Model\SubjectTable');

        return new SubjectSelect($subjectTable);
    }
}
