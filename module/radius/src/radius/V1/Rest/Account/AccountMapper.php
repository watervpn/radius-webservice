<?php

namespace radius\V1\Rest\Account;

use Zend\Db\Sql\Select;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;
use Lib\Model\AbstractEntity;
use Lib\Radius\Entity\CheckEntity;
use Lib\Radius\Entity\UserGroupEntity;
use Lib\Model\Exception as Exception;

class AccountMapper
{
    protected $adapter;
    //protected $entityPrototype;
    protected $checkMapper;
    protected $groupMapper;
    protected $groupCheckMapper;

    public function __construct(AdapterInterface $adapter, $checkMapper = null, $groupMapper = null, $groupCheckMapper)
    {
        $this->adapter = $adapter;
        $this->checkMapper = $checkMapper;
        $this->groupMapper = $groupMapper;
        $this->groupCheckMapper = $groupCheckMapper;
        //$this->entityPrototype = new Entity;
    }

    /**
     * Save account
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function save(AbstractEntity $obj){
        $data = $obj->getArrayCopy();
        //Todo: find check record : check user exist or not
        $check = new CheckEntity(null, $data['id'], 'User-Password', ':=', $data['passwd']);
        $groups = array();
        foreach($data['groups'] as $group){
            $groups[] = new UserGroupEntity($data['id'], $group, '1');
        }
        $this->checkMapper->save($check);
        $this->groupMapper->updateByArrayObjs($groups);
    }

    /**
     * Delete account 
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete(AbstractEntity $obj){
        $data = $obj->getArrayCopy();
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
            $groups = $this->groupMapper->findByUser($accountId);
            $groupValues = array_column($groups->toArray(), 'groupname');

            // user is deactive if it belongs to deactivite group else is active
            (in_array('deactivite', $groupValues) ? $status = AccountEntity::INACTIVE : $status = AccountEntity::ACTIVE);
             return $account = new AccountEntity($check->getUsername(), $check->getValue(), $groupValues, $status, array('')); 

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
        $entity = new AccountEntity();
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
    public function findAll($offset = 0, $limit = 100){
        $accounts = array();
        $checks = $this->checkMapper->findAll($offset, $limit);
        $groupValues = null;
        foreach($checks as $check){
            try{
                $groups = $this->groupMapper->findByUser($check->getUsername());
                $groupValues = array_column($groups->toArray(), 'groupname');
            }catch( Exception\ObjectNotFoundException $e){
               // if user has no group skip
            }
            (in_array('deactivite', $groupValues) ? $status = AccountEntity::INACTIVE : $status = AccountEntity::ACTIVE);
            // Create account Entity
            $accounts[] = new AccountEntity($check->getUsername(), $check->getValue(), $groupValues, $status, array('')); 
        }
        return $accounts;
        //$select = new Select('radcheck');
        //$paginatorAdapter = new DbSelect($select, $this->adapter);
        //$collection = new AccountCollection($paginatorAdapter);
        //return $collection;
    }

    /**
     * @param array $item 
     * @return Entity
     */
    protected function createEntity(array $item)
    {
        //return $this->hydrator->hydrate($item, $this->entityPrototype);
    }

}
