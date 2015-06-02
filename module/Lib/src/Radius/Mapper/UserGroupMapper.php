<?php
namespace Lib\Radius\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Lib\Model\AbstractMapper;
use Lib\Model\AbstractEntity;
use Lib\Model\Exception as Exception;

class UserGroupMapper extends AbstractMapper
{
    /**
     * Overwrite MapperAbstract primaryKey 
     * The db primary key's column name 
     */
    protected $primaryKey = 'id';

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


    /**
     * Find row by user
     *
     * @return Zend\Db\ResultSet\ResultSet
     */
    public function findByUser($username)
    {
        $rowset = $this->tableGateway->select(array('username' => $username));
        if ($rowset->count() <=0) {
            throw new Exception\ObjectNotFoundException("Could not find row: [$groupname]");
        }
        return $rowset;
    }

    /**
     * Find row by group
     *
     * @return Zend\Db\ResultSet\ResultSet
     */
    public function findByGroup($groupname)
    {
        $rowset = $this->tableGateway->select(array('groupname' => $groupname));
        if ($rowset->count() <=0) {
            throw new Exception\ObjectNotFoundException("Could not find row: [$groupname]");
        }
        return $rowset;
    }
   
    /**
     * Find row by user and group
     *
     * @return Zend\Db\ResultSet\ResultSet
     */
    public function findByUserGroup($username, $groupname)
    {
        $rowset = $this->tableGateway->select(array('username' => $username, 'groupname' => $groupname));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception\ObjectNotFoundException("Could not find row: username [$username] and groupname [$groupname]");
        }
        return $row;
    }

    public function save(AbstractEntity $obj)
    {
        $data = $obj->getArrayCopy();

        $username = $obj->getUsername();
        $groupname = $obj->getGroupname();
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
