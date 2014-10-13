<?php

namespace File\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class FileController extends AbstractActionController {

    protected $fileTable;
    protected $options;

    public function indexAction() {
        throw new \BadMethodCallException('Method not implemented');
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
            $this->options = $sm->get('Upload\Options\ModuleOptions');
        }
        return $this->options;
    }

}
