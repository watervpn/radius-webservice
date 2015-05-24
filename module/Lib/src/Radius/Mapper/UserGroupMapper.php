<?php
namespace Lib\Radius\Mapper;

use Zend\Db\TableGateway\TableGateway;

class UserGroupMapper
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

    /**
     * compositeKey = username_groupname
     */
    public function find($compositeKey)
    {
        list($username, $groupname) = explode('_', $compositeKey);
        $rowset = $this->tableGateway->select(array('username' => $username, 'groupname' => $groupname));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $username");
        }
        return $row;
    }

    public function findByUser($username)
    {
        $rowset = $this->tableGateway->select(array('username' => $username));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $username");
        }
        return $row;
    }

    // Todo: return Collection
    public function findByGroup($groupname)
    {
        $rowset = $this->tableGateway->select(array('groupname' => $groupname));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function save(UserGroupEntity $userGroup)
    {
        $data = array(
            'username' => $userGroup->getUsername(),
            'groupname'  => $userGroup->getGroupname(),
            'priority'  => $userGroup->getPriority(),
        );

        $username = $userGroup->getUsername();
        $groupname = $userGroup->getGroupname();
        // Insert & Update
        if (!empty($username) && !empty($groupname)) {
            if($this->find($username.'_'.$groupname)){
                $this->tableGateway->update($data, array('username' => $username, 'groupname' => $groupname));
            }else{
                $this->tableGateway->insert($data);
            }
        } else {
            throw new \Exception('GroupCheck id does not exist');
        }
    }


}
