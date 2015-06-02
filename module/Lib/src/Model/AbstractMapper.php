<?php
namespace Lib\Model;

use Zend\Stdlib\Hydrator;
use Zend\Db\TableGateway\TableGateway;
use Lib\Model\Exception as Exception;

Abstract class AbstractMapper
{

    protected $tableGateway;
    protected $primaryKey;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Find a record by pimary key
     *
     * @param  mixed $id
     * @return AbstractEntity|TableGateway
     */
    public function find($id)
    {
        if(!isset($this->primaryKey)){
            $this->primaryKey = 'id';
        }
        $rowset = $this->tableGateway->select(array($this->primaryKey => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception\ObjectNotFoundException("Could not find row: [$id]");
        }
        return $row;
    }

    /**
     * Find all records
     *
     * @return AbstractEntity|TableGateway
     */
    public function findAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }


    /**
     * Save object to database
     *
     * @param  AbstractEntity $data
     */
    public function save(AbstractEntity $obj)
    {
        $data = $obj->getArrayCopy();
        try{
            // Get object's primary key value
            $id =  $obj->{'get'.ucfirst($this->primaryKey)} ();
        }catch(Exception $e){
            throw new Exception\ObjectNotFoundException("Error getting primary key using getter: [get".ucfirst($this->primaryKey)."] error: {$e->getMessage()}");
        }

        // Insert & Update
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->find($id)) {
                $this->tableGateway->update($data, array( $this->primaryKey => $id));
            } else {
                throw new Exception\ObjectNotFoundException('Check id does not exist');
            }
        }
    }


    /**
     * Delete object to database
     *
     * @param $id
     * @return bool
     */
    public function delete(AbstractEntity $obj)
    {
        $data = $obj->getArrayCopy();
        try{
            // Get object's primary key value
            $id =  $obj->{'get'.ucfirst($this->primaryKey)} ();
        }catch(Exception $e){
            throw new Exception\ObjectNotFoundException("Error getting primary key using getter: [get".ucfirst($this->primaryKey)."] error: {$e->getMessage()}");
        }

        if ($id !=0 && $this->find($id)){
            $this->tableGateway->delete($data);
        }

    }



}
