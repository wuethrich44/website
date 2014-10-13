<?php

namespace Upload\Adapter;

use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Zend\Filter\File\Rename;
use Zend\File\Transfer\Adapter\Http;

class UploadHttp extends Http
{

    public function __construct($moduleOptions, $options = array())
    {
        parent::__construct($options);

        $size      = new Size(array('max' => $moduleOptions->getMaxFileSizeInByte()));
        $extension = new Extension($moduleOptions->getAllowedFileExtensions());

        if ($moduleOptions->getRandomizeFileName()) {
            $rename = new Rename(array(
                'target' => $moduleOptions->getUploadFolderPath().'/file',
                'randomize' => true,
            ));
        } else {
            $rename = null;
        }

        $this->setValidators(array($size, $extension));
        $this->setFilters(array($rename));
    }

}
