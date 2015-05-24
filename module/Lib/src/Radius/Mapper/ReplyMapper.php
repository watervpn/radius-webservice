<?php
namespace Lib\Radius\Mapper;

use Zend\Db\TableGateway\TableGateway;

class ReplyMapper
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

    public function findByUser($username)
    {
        $rowset = $this->tableGateway->select(array('username' => $username));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function save(ReplyEntity $reply)
    {
        $data = array(
            'id' => $reply->id,
            'username'  => $reply->username,
            'attribute'  => $reply->attribute,
            'op'  => $reply->op,
            'value'  => $reply->value,
        );

        $id = (int) $reply->id;
        // Insert & Update
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->find($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Check id does not exist');
            }
        }
    }


}
