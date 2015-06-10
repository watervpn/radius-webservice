<?php
namespace Lib\Model;

//use Zend\Stdlib\Hydrator;
use Zend\Db\TableGateway\TableGateway;
use Lib\Model\Exception as Exception;
use Zend\Db\Sql\Select;

Abstract class AbstractMapper
{
    protected $tableGateway;
    protected $primaryKeys = array();

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
    private function getPrimaryKeyData(array $data)
    {
        $pk = array();
        foreach($this->primaryKeys as $primaryKey){
            if(array_key_exists($primaryKey, $data)){
                $pk[$primaryKey] = $data[$primaryKey];
            }
        }
        return $pk;
    }

    /**
     * Find a record by pimary key
     *
     * @param  mixed|array $id
     * @return AbstractEntity|TableGateway
     */
    public function find($pks)
    {
        if(empty($this->primaryKeys)){
            return false;
        }
        $data = array();
        if(is_array($pks)){
            // verfiy total pass in primary keys 
            if(count($pks) != count($this->primaryKeys)){
                throw new \Exception("The number of primary keys doesn't match, it should contain:".print_r($this->primaryKeys, false));
            }
            // convert to key & value data format
            foreach($this->primaryKeys as $key => $primaryKey){
                $data[$primaryKey] = current($pks);
                next($pks);
            }
        }else{
            // when pks pass in as string (not array) primary key has to be only 1
            if(count($this->primaryKeys) != 1){
                throw new \Exception("The number of primary keys doesn't match, it should contain:".print_r($this->primaryKeys, false));
            }
            $data[$this->primaryKeys[0]] = $pks;
        }
        $rowset = $this->tableGateway->select($data);
        $row = $rowset->current();
        if (!$row) {
            throw new Exception\ObjectNotFoundException(__CLASS__." Could not find row: [".print_r($pks,false)."]");
        }
        return $row;
    }

    /**
     * Find all records
     *
     * @return AbstractEntity|TableGateway
     */
    public function findAll($offset = 0, $limit = 100)
    {
        //$resultSet = $this->tableGateway->select();
        $resultSet = $this->tableGateway->select(function (Select $select) use ($offset, $limit){
            $select->limit(intval($limit))->offset(intval($offset));
        });
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
        $pks = $this->getPrimaryKeyData($data);
        $isInsert = false;
        // check if any primary keys are empty
        foreach($pks as $pk){
            if(empty($pk)){
                $isInsert = true;
                break;
            }
        }

        // Insert & Update
        if ($isInsert) {
            $this->tableGateway->insert($data);
        } else {
            //if ($this->find($pks)) {
            try{
                $this->find($pks);
                $this->tableGateway->update($data, $pks);
            }catch (Exception\ObjectNotFoundException $e){
                $this->tableGateway->insert($data);
            }
            /*} else {
                throw new Exception\ObjectNotFoundException(__CLASS__.' update error primary key'. print_r($pks, false) .' does not exist');
            }*/
        }
    }

    /**
     * Save account
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function saveByArrayObjs(array $objs){
        foreach($objs as $obj){
            $this->save($obj);
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
        $pks = $this->getPrimaryKeyData($data);

        // check if any primary keys are empty
        foreach($pks as $pk){
            if(empty($pk)){
                // throw exception
                return false;
            }
        }
        if ($this->find($pks)){
            $this->tableGateway->delete($pks);
        }

    }

}
