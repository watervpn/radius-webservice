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
    protected $primaryKeys = array('username', 'groupname');

    /**
     * Find row by user
     *
     * @return Zend\Db\ResultSet\ResultSet
     */
    public function findByUser($username)
    {
        $rowset = $this->tableGateway->select(array('username' => $username));
        if ($rowset->count() <=0) {
            throw new Exception\ObjectNotFoundException(__CLASS__." Could not find row: [$username]");
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
            throw new Exception\ObjectNotFoundException(__CLASS__." Could not find row: [$groupname]");
        }
        return $rowset;
    }

    /**
     * Update group by array objects
     * It chcek and delete user from the group if group does not exist in the array objects
     * It check and add user to the group if user not already belong to the group
     *
     * @param array of Usergroupentity 
     */
    public function updateByArrayObjs(array $objs){
        // if array not exist, delete
        // findByUser and delete group not exist in pass in $objs
        $username = $objs[0]->getUsername();
        try{
            $groups = $this->findByUser($username);
        }catch(Exception\ObjectNotFoundException $e){
            $groups = null;
        }

        $createObjs = $objs;    // UserGroupEntity array objs
        $deleteObjs = array();  // Usergroupentity array objs
        $updateObjs = array();  // Usergroupentity array objs

        // Construct update, create, delete obj lists
        if(!empty($groups)){
            foreach($groups as $gIndex => $group){
                $isDelete = true;
                // Remove exist group obj from create list
                foreach($objs as $oIndex => $obj){
                    if($obj->getGroupname() == $group->getGroupname()){
                        // Create List
                        unset($createObjs[$oIndex]);
                        $isDelete = false;
                        break;
                    }
                }
                if($isDelete){
                    // Delete list
                    $deleteObjs[] = $group;
                }else{
                    // Update list
                    $updateObjs[] = $group;
                }
            }
        }

        // Process all obj list
        // Create
        if(!empty($createObjs)){
            foreach($createObjs as $obj){
                if(empty($obj->getGroupname()) || empty($obj->getUsername())){
                    continue;
                }
                $this->save($obj);
            }
        }
        // Delete
        if(!empty($deleteObjs)){
            foreach($deleteObjs as $obj){
                if(empty($obj->getGroupname()) || empty($obj->getUsername())){
                    continue;
                }
                $this->delete($obj);
            }
        }
        // Update
        if(!empty($updateObjs)){
            foreach($updateObjs as $obj){
                if(empty($obj->getGroupname()) || empty($obj->getUsername())){
                    continue;
                }
                $this->save($obj);
            }
        }

        echo "delete object";
        print_r($deleteObjs);
        echo "create object";
        print_r($createObjs);
        echo "Update object";
        print_r($updateObjs);

    }

}
