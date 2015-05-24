<?php
namespace Lib\Radius\Mapper;

use Zend\Db\TableGateway\TableGateway;

class GroupCheckMapper
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function findAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function find($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function findByGroup($groupname)
    {
        $rowset = $this->tableGateway->select(array('groupname' => $groupname));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function save(GroupCheckEntity $groupCheck)
    {
        $data = array(
            'id' => $groupCheck->id,
            'groupname'  => $groupCheck->groupname,
            'attribute'  => $groupCheck->attribute,
            'op'  => $groupCheck->op,
            'value'  => $groupCheck->value,
        );

        $id = (int) $groupCheck->id;
        // Insert & Update
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->find($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('GroupCheck id does not exist');
            }
        }
    }


}
