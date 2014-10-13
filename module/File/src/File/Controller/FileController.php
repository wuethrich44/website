<?php

namespace File\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use File\Model\File;
use File\Form\UploadForm;

class FileController extends AbstractActionController {

    protected $subjectTable;
    protected $categoryTable;
    protected $fileTable;
    protected $options;

    public function indexAction() {
        throw new \BadMethodCallException('Method not implemented');
    }

    public function addAction() {
        $form = $this->getServiceLocator()->get('FormElementManager')->get('File\Form\UploadForm');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $file = new File();

            $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);

            $adapter = $this->getServiceLocator()->get('File\Adapter\Http');

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
                    $subjectID = $data['subject'];
                    $categoryID = $data['category'];
                    $dbdata = array();
                    $dbdata['fileName'] = $data['file']['name'];
                    $filename = $adapter->getFileName();
                    if (is_array($filename)) {
                        $dbdata['url'] = basename(current($filename));
                    } else {
                        $dbdata['url'] = basename($filename);
                    }

                    $file->exchangeArray($dbdata);

                    $this->getFileTable()->saveFile($file, $subjectID, $categoryID);

                    header('HTTP/1.1 200 OK');
                    exit();
                }
            }
        }

        return array(
            'form' => $form
        );
    }

    public function editAction() {
        throw new \BadMethodCallException('Method not implemented');
    }

    /**
     * Delete the given file from disk and database
     *
     * @throws \Exception Could not delete file
     * @throws \InvalidArgumentException File not found
     * @return \Zend\Http\Response|null
     */
    public function deleteAction() {
        $fileID = (int) $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();

        if ($fileID and $request->isXmlHttpRequest()) {
            try {

                $file = $this->getFileTable()->getFile($fileID);
                $filePath = $this->getOptions()->getUploadFolderPath() . '/' . $file->url;

                if (file_exists($filePath)) {
                    if (!unlink($filePath)) {
                        throw new \Exception('Could not delete file');
                    }
                }

                $this->getFileTable()->deleteFile($fileID);

                echo json_encode(array('state' => true));
                exit();
            } catch (\Exception $e) {
                echo json_encode(array('state' => false));
                exit();
            }
        }
    }

    public function getSubjectTable() {
        if (!$this->subjectTable) {
            $sm = $this->getServiceLocator();
            $this->subjectTable = $sm->get('Subject\Model\SubjectTable');
        }
        return $this->subjectTable;
    }

    public function getCategoryTable() {
        if (!$this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Category\Model\CategoryTable');
        }
        return $this->categoryTable;
    }

    public function getFileTable() {
        if (!$this->fileTable) {
            $sm = $this->getServiceLocator();
            $this->fileTable = $sm->get('File\Model\FileTable');
        }
        return $this->fileTable;
    }

    public function getOptions() {
        if (!$this->options) {
            $sm = $this->getServiceLocator();
            $this->options = $sm->get('File\Options\ModuleOptions');
        }
        return $this->options;
    }

}
