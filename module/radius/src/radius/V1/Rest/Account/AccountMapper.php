<?php

namespace radius\V1\Rest\Account;

use Zend\Db\Sql\Select;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;

class AccountMapper
{
    protected $adapter;
    protected $hydrator;
    protected $entityPrototype;
    protected $checkMapper;

    public function __construct(AdapterInterface $adapter, $checkMapper = null)
    {
        $this->adapter = $adapter;
        $this->checkMapper = $checkMapper;
        //$this->hydrator = new ObjectPropertyHydrator();
        //$this->entityPrototype = new Entity;
    }

    public function create($id, $data){
    }

    public function delete(){
    }

    public function fetch($accountId){
        return $check = $this->checkMapper->findByUser($accountId);
        //$account = new AccountEntity();
        //$account->exchangeArray($check->getArrayCopy());
        //return $account;

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

    public function fetchAll(){
        return $check = $this->checkMapper->findAll();
        //$select = new Select('radcheck');
        //$paginatorAdapter = new DbSelect($select, $this->adapter);
        //$collection = new AccountCollection($paginatorAdapter);
        //return $collection;
    }

    public function update($id, $data){
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
