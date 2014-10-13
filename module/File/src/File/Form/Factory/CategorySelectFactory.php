<?php

namespace File\Form\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use File\Form\Element\CategorySelect;

class CategorySelectFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $categoryTable = $serviceLocator->getServiceLocator()->get('Category\Model\CategoryTable');

        return new CategorySelect($categoryTable);
    }
}
