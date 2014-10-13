<?php

namespace File\Form;

use Zend\Form\Form;

class UploadForm extends Form
{

    public function init()
    {
        $this->setAttribute('data-ajax', 'false');
        $this->setAttribute('class', 'dropzone');

        $this->add(
            array(
                'name' => 'subject',
                'type' => 'SubjectSelect',
                'attributes' => array(
                    'class' => 'form-control',
                    'id' => 'subject',
                ),
                'options' => array(
                    'label' => 'Modul'
                )
        ));

        $this->add(
            array(
                'name' => 'category',
                'type' => 'CategorySelect',
                'attributes' => array(
                    'class' => 'form-control',
                    'id' => 'category',
                ),
                'options' => array(
                    'label' => 'Kategorie'
                )
        ));
    }
}
