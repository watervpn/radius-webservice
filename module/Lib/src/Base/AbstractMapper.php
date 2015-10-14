<?php
namespace Lib\Base;

//use Zend\Stdlib\Hydrator;
use Zend\Db\TableGateway\TableGateway;
use Lib\Base\Exception as Exception;
use Zend\Db\Sql\Select;

Abstract class AbstractMapper
{
    protected $tableGateway;
    protected $primaryKeys = array();

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getTableGateway(){
        return $this->tableGateway;
    }
    /**
     * Filer data array to contain only perimay key's data array
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
    public function find($ids)
    {
        if(empty($this->primaryKeys)){
            return false;
        }
        $data = array();
        if(is_array($ids)){
            if(array_search("", $ids) !== false){
                throw new \Exception(__CLASS__." function: ".__FUNCTION__."() primary keys can not contain empty value :".print_r($this->ids, true));
            }
            // verfiy total pass in primary keys 
            if(count($ids) != count($this->primaryKeys)){
                throw new \Exception("The number of primary keys doesn't match, it should contain:".print_r($this->primaryKeys, true));
            }
            // convert to key & value data format
            foreach($this->primaryKeys as $key => $primaryKey){
                $data[$primaryKey] = current($ids);
                next($ids);
            }
        }else{
            // when ids pass in as string (not array) primary key has to be only 1
            if(count($this->primaryKeys) != 1){
                throw new \Exception("The number of primary keys doesn't match, it should contain:".print_r($this->primaryKeys, true));
            }
            $data[$this->primaryKeys[0]] = $ids;
        }
        $rowset = $this->tableGateway->select($data);
        $row = $rowset->current();
        if (!$row) {
            throw new Exception\ObjectNotFoundException(__CLASS__." Could not find row: [".print_r($ids, true)."]");
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
        // Filter data to only primary key's value
        $ids = $this->getPrimaryKeyData($data);
        $isInsert = false;
        // check if any primary keys are empty
        foreach($ids as $id){
            if(empty($id)){
                $isInsert = true;
                break;
            }
        }

        // Insert & Update
        if ($isInsert) {
            $this->tableGateway->insert($data);
        } else {
            //if ($this->find($ids)) {
            try{
                $this->find($ids);
                $this->tableGateway->update($data, $ids);
            }catch (Exception\ObjectNotFoundException $e){
                $this->tableGateway->insert($data);
            }
            /*} else {
                throw new Exception\ObjectNotFoundException(__CLASS__.' update error primary key'. print_r($ids, true) .' does not exist');
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
        $ids = $this->getPrimaryKeyData($data);

        // check if any primary keys are empty
        foreach($ids as $id){
            if(empty($id)){
                throw new \Exception("The number of primary keys doesn't match, it should contain:".print_r($this->primaryKeys, true));
                // throw exception
                return false;
            }
        }
        if ($this->find($ids)){
            $this->tableGateway->delete($ids);
        }

    }

}
