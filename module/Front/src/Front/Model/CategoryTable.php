<?php

namespace Front\Model;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Sql\Select;

class CategoryTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll(array $filtr = array(), array $order = array(), array $limit = array())
    {
        $filtr = $this->fetchAllFiltr($filtr);
        $resultSet = $this->tableGateway->select(function (Select $select) use($filtr, $order, $limit) {
                    $select->where($filtr);
                    foreach($order as $orderOne) {
                        $select->order($orderOne['sort'] . ' ' . $orderOne['order']);
                    }
                    if(!empty($limit)) {
                        $select->limit($limit['start'] . ',' . $limit['stop']);
                    }
                });
        return $resultSet;
    }

    /**
     * 
     * @param array $filtr
     * @return array
     */
    private function fetchAllFiltr(array $filtr)
    {
        if (!is_array($filtr) || count($filtr) == 0) {
            return array();
        }

        $return = array();
        if (isset($filtr['url']) && !empty($filtr['url'])) {
//            $return['url'] = trim($filtr['url']);
            $return = array(
                'url' => trim($filtr['url'])
            );
        }

        return $return;
    }

    public function getCategory($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveCategory(Category $category)
    {
//        if(empty($category->url) || $category->url == null) {
        $category->url = $category->name;
//        }

        $category->url = \Front\Model\Common\Url::clear($category->url);

        $data = array(
            'name' => $category->name,
            'idParent' => $category->idParent,
            'url' => $category->url
        );

        $id = (int) $category->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCategory($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteCategory($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }

    public function getSelectList()
    {
        $return = array();
        foreach ($this->tableGateway->select() as $category) {
            $return[$category->id] = $category->name;
        }
        return $return;
    }

    public function getTree($idParent = 0)
    {
        $categories = $this->fetchAll(array(), array(array('sort'=>'idParent', 'order'=>'ASC'))); 
       /* @var $categories Zend\Db\ResultSet\ResultSet */
//        $categories->buffer();
        $categoriesArray = array();
        foreach ($categories as $category) {
            $categoriesArray[] = $category;
        }

        return $this->_getTree($categoriesArray, $idParent);
    }

    private function _getTree(array $categories, $idParent = 0)
    {
        $idParent = (int) $idParent;
        $tree = array();
        foreach ($categories as $category) {
            /* @var $category \Front\Model\Category */
            if ($idParent == $category->idParent) {
                $tree[$category->id] = $category;
                $tree[$category->id]->children = $this->_getTree($categories, $category->id);
            }
        }

        return $tree;
    }

}