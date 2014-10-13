<?php

namespace Upload\Form\Element;

use Zend\Form\Element\Select;
use Subject\Model\SubjectTable;

class SubjectSelect extends Select
{

    public function __construct(SubjectTable $subjectTable = null, $name = null, $options = array())
    {
        parent::__construct($name, $options);

        $subjects = $subjectTable->fetchAll();
        $valueOptions  = array();

        foreach ($subjects as $subject) {
            $valueOptions[$subject->subjectID] = $subject->name.' | '.$subject->abbreviation;
        }

        $this->setValueOptions($valueOptions);
    }
}
