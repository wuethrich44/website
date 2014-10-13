<?php

namespace File\Form\Element;

use Zend\Form\Element\Select;
use Category\Model\CategoryTable;

class CategorySelect extends Select
{

    public function __construct(CategoryTable $categoryTable = null, $name = null, $options = array())
    {
        parent::__construct($name, $options);

        $categories = $categoryTable->fetchAll();
        $valueOptions  = array();

        foreach ($categories as $category) {
            $valueOptions[$category->categoryID] = $category->name;
        }

        $this->setValueOptions($valueOptions);
    }
}
