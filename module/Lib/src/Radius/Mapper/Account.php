<?php

namespace Lib\Radius\Mapper;

use Zend\Db\Adapter\AdapterInterface;
//use Zend\Paginator\Adapter\DbSelect;
//use Zend\Db\Sql\Select;
use Lib\Radius\Model\Check as CheckModel;
use Lib\Radius\Model\UserGroup as UserGroupModel;
use Lib\Radius\Model\Account as AccountModel;
use Lib\Base\Exception as Exception;

class Account
{
    protected $adapter;
    protected $entity;
    protected $checkMapper;
    protected $groupMapper;
    protected $groupCheckMapper;

    public function __construct(AdapterInterface $adapter, $entity, $checkMapper = null, $groupMapper = null, $groupCheckMapper)
    {
        $this->adapter = $adapter;
        $this->checkMapper = $checkMapper;
        $this->groupMapper = $groupMapper;
        $this->groupCheckMapper = $groupCheckMapper;
        $this->entity = $entity;
    }

    /**
     * Save account
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function save(AccountModel $obj){
        $data = $obj->getArrayCopy();
        // RadCheck
        try{
            // Update
            $check = $this->checkMapper->findByUserAttrOp($data['id'], 'User-Password', ':=');
            if(isset($data['passwd'])){ $check->setValue($data['passwd']); }
        }catch(Exception\ObjectNotFoundException $e){
            // Insert
            $check = new CheckModel(null, $data['id'], 'User-Password', ':=', $data['passwd']);
        }
        // RadUserGroup
        $groups = array();
        if( !empty($data['groups']) && is_array($data['groups']) ){
            foreach($data['groups'] as $group){
                try{
                    // Update
                    if(!empty($group)){
                        $groups[] = $this->groupMapper->find( array($data['id'], $group) );
                    }
                }catch(Exception\ObjectNotFoundException $e){
                    // Insert
                    if(!empty($group)){
                        $groups[] = new UserGroupModel($data['id'], $group, '1');
                    }
                }
            }
        }
        $this->checkMapper->save($check);
        $this->groupMapper->updateByArrayObjs($groups, $check->getUsername());
    }

    /**
     * Delete account 
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete(AccountModel $obj){
        $check = $this->checkMapper->findByUserAttrOp($obj->getId(), 'User-Password', ':=');
        try{
            $groups = array();
            foreach($obj->getGroups() as $groupName){
                $groups[] = $this->groupMapper->find( array($obj->getId(), $groupName) );
            }
        }catch(Exception\ObjectNotFoundException $e){
            //throw $e;
        }

        // Delete
        try{
            foreach($groups as $group){
                $this->groupMapper->delete($group);
            }
            $this->checkMapper->delete($check);
            return true;
        }catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Find account by username
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function find($accountId){
        try{
            $check = $this->checkMapper->findByUserAttrOp($accountId, 'User-Password', ':=');
            try{
                $groups = $this->groupMapper->findByUser($accountId);
                $groupValues = array_column($groups->toArray(), 'groupname');
            }catch(Exception\ObjectNotFoundException $e){
                // set groupValues empty if user doesn't belongs to any group
                $groupValues = array();
            }

            // user is deactive if it belongs to deactivite group else is active
            (in_array('deactivite', $groupValues) ? $status = AccountModel::INACTIVE : $status = AccountModel::ACTIVE);
             //return $account = new AccountModel($check->getUsername(), $check->getValue(), $groupValues, $status, array('')); 
            $this->entity->setId($check->getUsername());
            $this->entity->setPasswd($check->getValue());
            $this->entity->setGroups($groupValues);
            $this->entity->setStatus($status);
            $this->entity->setOptions(array());
            return $this->entity;

        }catch(\Exception $e){
            throw $e;
        }

        /*
        $sql = 'SELECT * FROM radcheck WHERE username = ?';
        $resultset = $this->adapter->query($sql, array($accountId));
        //print_r($resultset->toArray());
        $data = $resultset->toArray();
        if (!$data) {
          //return false;
        }
        $entity = new AccountModel();
        $entity->exchangeArray($data[0]);
        return $entity;
         */
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function findAll($orderby=null, $sort=null, $offset = 0, $limit = 100){
        $accounts = array();
        $checks = $this->checkMapper->findAll($orderby, $sort, $offset, $limit);
        $groupValues = null;
        foreach($checks as $check){
            try{
                $groups = $this->groupMapper->findByUser($check->getUsername());
                $groupValues = array_column($groups->toArray(), 'groupname');
            }catch( Exception\ObjectNotFoundException $e){
               // if user has no group skip
            }
            (in_array('deactivite', $groupValues) ? $status = AccountModel::INACTIVE : $status = AccountModel::ACTIVE);

            // Create account Entity
            $this->entity->setId( $check->getUsername() );  
            $this->entity->setPasswd( $check->getValue() );  
            $this->entity->setGroups( $groupValues );  
            $this->entity->setStatus( $status );  
            $this->entity->setOptions( array() );  
            $accounts[] = clone $this->entity;
            //$accounts[] = new AccountModel($check->getUsername(), $check->getValue(), $groupValues, $status, array('')); 
        }
        return $accounts;
        //$select = new Select('radcheck');
        //$paginatorAdapter = new DbSelect($select, $this->adapter);
        //$collection = new AccountModel($paginatorAdapter);
        //return $collection;
    }

}
