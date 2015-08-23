<?php
namespace Lib\Model;

//use Zend\Stdlib\Hydrator;

Abstract class AbstractRespondent
{

    public function __construct(){
    }

    abstract public function create($data);
    abstract public function delete($data);
    abstract public function update($id, $data);
    abstract public function fetch($id);
    //abstract public function fetchAll($id);
    /**
     *
     * Convert array to object
     *
     * @param array
     */
    //abstract public function exchangeArray(array $data);
    
    /**
     * Convert object to array
     *
     * @return array
     */
    //abstract public function getArrayCopy();
}
