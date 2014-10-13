<?php

namespace Upload\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use File\Model\File;

class UploadController extends AbstractActionController
{

    public function indexAction()
    {
        $form = $this->getServiceLocator()->get('FormElementManager')->get('Upload\Form\UploadForm');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $file = new File();

            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);

            $adapter = $this->getServiceLocator()->get('Upload\Adapter\Http');

            if (!$adapter->isValid()) {
                $dataError = $adapter->getMessages();
                array_merge($dataError, $adapter->getErrors());
                foreach ($dataError as $key => $row) {
                    echo $row;
                }

                header('HTTP/1.1 500 Internal Server Error');
                exit();
            } else {
                if ($adapter->receive()) {
                    $subjectID          = $data['subject'];
                    $categoryID         = $data['category'];
                    $dbdata             = array();
                    $dbdata['fileName'] = $data['file']['name'];
                    $filename           = $adapter->getFileName();
                    if (is_array($filename)) {
                        $dbdata['url'] = basename(current($filename));
                    } else {
                        $dbdata['url'] = basename($filename);
                    }

                    $file->exchangeArray($dbdata);

                    $this->getFileTable()->saveFile($file, $subjectID,
                        $categoryID);

                    header('HTTP/1.1 200 OK');
                    exit();
                }
            }
        }

        return array(
            'form' => $form
        );
    }

    public function getFileTable()
    {
        if (!$this->fileTable) {
            $sm              = $this->getServiceLocator();
            $this->fileTable = $sm->get('File\Model\FileTable');
        }
        return $this->fileTable;
    }
}
