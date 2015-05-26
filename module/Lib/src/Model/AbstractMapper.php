<?php
namespace Lib\Model;

use Zend\Stdlib\Hydrator;
use Zend\Db\TableGateway\TableGateway;

Abstract class AbstractMapper
{

    protected $tableGateway;
    protected $primaryKey;

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
        if(!isset($this->primaryKey)){
            $this->primaryKey = 'id';
        }
        $rowset = $this->tableGateway->select(array($this->primaryKey => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function save(AbstractEntity $obj)
    {
        $data = $obj->getArrayCopy();
        try{
            // get object primarykey value
            $id =  $obj->{'get'.ucfirst($this->primaryKey)} ();
        }catch(Exception $e){
            throw $e;
        }
        // Insert & Update
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->find($id)) {
                $this->tableGateway->update($data, array( $this->primaryKey => $id));
            } else {
                throw new \Exception('Check id does not exist');
            }
        }
    }





}
