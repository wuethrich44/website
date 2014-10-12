<?php

namespace Download\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Response\Stream;
use Zend\Http\Headers;

class DownloadController extends AbstractActionController {

    protected $subjectTable;
    protected $categoryTable;
    protected $fileTable;
    protected $options;

    /**
     * Display view depended on the given parameters
     *
     * (non-PHPdoc)
     *
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction() {
        $subjectID = (int) $this->getSubjectTable()->getSubjectID(
                        $this->params()->fromRoute('subject'));
        $categoryID = (int) $this->getCategoryTable()->getCategoryID(
                        $this->params()->fromRoute('category'));
        $fileID = (int) $this->params()->fromRoute('file');

        if ($subjectID and ! $categoryID) {
            // If a subject ID given, show the category view
            return $this->showCategoryView($subjectID);
        }

        if ($subjectID and $categoryID and ! $fileID) {
            // If a subject and category ID given, show the download view
            return $this->showDownloadView($subjectID, $categoryID);
        }

        if ($subjectID and $categoryID and $fileID) {
            // If a subject, category and file ID given, download the file
            return $this->downloadFile($fileID);
        }

        // If no ID given, show the subject view
        return $this->showSubjectView();
    }

    /**
     * Display all used subjects
     *
     * @return ViewModel subject view
     */
    protected function showSubjectView() {
        $view = new ViewModel(array(
            'subjects' => $this->getSubjectTable()->getUsedSubjects()
        ));
        return $view->setTemplate('download/subject/index');
    }

    /**
     * Display all used categories in the given subject
     *
     * @param int $subjectID           
     * @return ViewModel category view
     */
    protected function showCategoryView($subjectID) {
        $view = new ViewModel(array(
            'subject' => $this->getSubjectTable()->getSubject($subjectID),
            'categories' => $this->getCategoryTable()->getUsedCategories($subjectID),
        ));
        return $view->setTemplate('download/category/index');
    }

    /**
     * Display all files in the given subject/category
     *
     * @param int $subjectID            
     * @param int $categoryID            
     * @return ViewModel file view
     */
    protected function showDownloadView($subjectID, $categoryID) {
        $view = new ViewModel(array(
            'subject' => $this->getSubjectTable()->getSubject($subjectID),
            'category' => $this->getCategoryTable()->getCategory($categoryID),
            'files' => $this->getFileTable()->getFiles($subjectID, $categoryID),
        ));
        return $view->setTemplate('download/file/index');
    }

    /**
     * Send header to download the given file
     *
     * @param int $fileID            
     * @return \Zend\Http\Response\Stream
     */
    protected function downloadFile($fileID) {
        $file = $this->getFileTable()->getFile($fileID);

        $this->getFileTable()->incrementDownloadCount($file);

        $fileUrl = $this->getOptions()->getDownloadFolderPath() . "/" . $file->url;

        if (!file_exists($fileUrl)) {
            throw new \Exception("File doesn't exists");
        }

        $response = new Stream();
        $response->setStream(fopen($fileUrl, 'r'));
        $response->setStatusCode(200);

        $headers = new Headers();
        $headers->addHeaderLine('Content-Type', 'application/octet-stream')
                ->addHeaderLine('Content-Disposition', 'attachment; filename="' . $file->name . '"')
                ->addHeaderLine('Cache-Control', 'must-revalidate')
                ->addHeaderLine('Pragma', 'public')
                ->addHeaderLine('Content-Length', filesize($fileUrl));

        $response->setHeaders($headers);
        return $response;
    }

    /**
     * Placeholder Upload
     */
    public function uploadAction() {
        return new ViewModel();
    }

    /**
     * Return the SubjectTableGateway
     * 
     * @return Subject\Model\SubjectTable
     */
    public function getSubjectTable() {
        if (!$this->subjectTable) {
            $sm = $this->getServiceLocator();
            $this->subjectTable = $sm->get('Subject\Model\SubjectTable');
        }
        return $this->subjectTable;
    }

    /**
     * Return the CategoryTableGateway
     * 
     * @return File\Model\CategoryTable
     */
    public function getCategoryTable() {
        if (!$this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Category\Model\CategoryTable');
        }
        return $this->categoryTable;
    }

    /**
     * Return the FileTableGateway
     * 
     * @return File\Model\FileTable
     */
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
            $this->options = $sm->get('Download\Options\ModuleOptions');
        }
        return $this->options;
    }

}
