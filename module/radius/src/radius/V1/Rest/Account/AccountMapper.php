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

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        //$this->hydrator = new ObjectPropertyHydrator();
        //$this->entityPrototype = new Entity;
    }

    public function create($id, $data){
    }

    public function delete(){
    }

    public function fetch($accountId){
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
    }

    public function fetchAll(){
        $select = new Select('radcheck');
        $paginatorAdapter = new DbSelect($select, $this->adapter);
        $collection = new AccountCollection($paginatorAdapter);
        return $collection;
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
