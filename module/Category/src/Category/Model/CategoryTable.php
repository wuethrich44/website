<?php

namespace Category\Model;

use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CategoryTable {

    protected $tableGateway;

    /**
     * Constructor
     *
     * @param TableGateway $tableGateway            
     */
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Return all categories
     *
     * @return \Zend\Db\ResultSet\ResultSet with Categories
     */
    public function fetchAll($paginated = false) {
        $select = $this->tableGateway->getSql()->select()->order('name');

        if ($paginated) {
            $paginatorAdapter = new DbSelect($select, $this->tableGateway->getAdapter(), $this->tableGateway->getResultSetPrototype());
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }

        return $this->tableGateway->selectWith($select);
    }

    /**
     * Return a categorie by ID
     *
     * @param int $categoryID            
     * @throws \Exception Categorie not found
     * @return \Zend\Db\ResultSet\ResultSet with Categories
     */
    public function getCategory($categoryID) {
        $categoryID = (int) $categoryID;
        $rowset = $this->tableGateway->select(
                array(
                    'categoryID' => $categoryID
        ));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find category with ID $categoryID");
        }
        return $row;
    }

    /**
     * Return a the cateogryID by category name
     * 
     * @param String $name 
     * @return int subjectID
     */
    public function getCategoryID($name) {
        $rowset = $this->tableGateway->select(
                array(
                    'name' => $name
        ));
        $row = $rowset->current();

        if (!$row) {
            return 0;
        }

        return $row->categoryID;
    }

    /**
     * Return all categories which include files
     *
     * @param unknown $subjectID            
     * @return \Zend\Db\ResultSet\ResultSet with Categories
     */
    public function getUsedCategories($subjectID) {
        $subjectID = (int) $subjectID;

        $select = $this->tableGateway->getSql()
                ->select()
                ->columns(array('*', 'fileCount' => new Expression('COUNT(files.fileID)')))
                ->join('files', 'categories.categoryID = files.categoryID', array())
                ->where(array('files.subjectID' => $subjectID))
                ->order('name')
                ->group('categories.categoryID');

        return $this->tableGateway->selectWith($select);
    }

    /**
     * Save (insert or update) a category object
     * 
     * @param Category $category
     * @throws \Exception Could not find category
     */
    public function saveCategory(Category $category) {
        $data = array(
            'name' => $category->name
        );

        $categoryID = (int) $category->categoryID;
        if ($categoryID == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCategory($categoryID)) {
                $this->tableGateway->update($data, array(
                    'categoryID' => $categoryID
                ));
            } else {
                throw new \Exception(
                "Could not find category with ID $categoryID");
            }
        }
    }

    /**
     * Delete a category with the specific ID
     * 
     * @param int $categoryID
     */
    public function deleteCategory($categoryID) {
        $this->tableGateway->delete(array('categoryID' => (int) $categoryID));
    }

}
