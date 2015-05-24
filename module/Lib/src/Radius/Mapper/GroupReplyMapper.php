<?php
namespace Lib\Radius\Mapper;

use Zend\Db\TableGateway\TableGateway;

class GroupReplyMapper
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

    public function save(GroupReplyEntity $groupReply)
    {
        $data = array(
            'id' => $groupReply->id,
            'groupname'  => $groupReply->groupname,
            'attribute'  => $groupReply->attribute,
            'op'  => $groupReply->op,
            'value'  => $groupReply->value,
        );

        $id = (int) $groupReply->id;
        // Insert & Update
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->find($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('GroupReply id does not exist');
            }
        }
    }


}
