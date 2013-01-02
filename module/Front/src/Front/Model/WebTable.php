<?php

// module/Album/src/Album/Model/AlbumTable.php:
namespace Front\Model;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Sql\Select;

class WebTable
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

        $resultSet->buffer();
        $resultSet->next();   
        return $resultSet; 
                
//        return $resultSet;
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
        if (isset($filtr['id_category']) && (int)$filtr['id_category']>0) {
            $return = array(
                'id_category' => (int)$filtr['id_category']
            );
        }

        return $return;
    }

    public function getWeb($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveWeb(Web $web)
    {
        $data = $web->getDataArray();

        
        $id = (int)$web->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getWeb($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteWeb($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}