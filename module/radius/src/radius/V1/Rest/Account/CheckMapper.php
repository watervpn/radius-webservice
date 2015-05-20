<?php

namespace radius\V1\Rest\Account;

use Zend\Db\TableGateway\TableGateway;

class CheckMapper
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

    public function save(CheckEntity $check)
    {
        $data = array(
            'id' => $check->id,
            'username'  => $check->username,
            'attribute'  => $check->attribute,
            'op'  => $check->op,
            'value'  => $check->value,
        );

        $id = (int) $check->id;
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
