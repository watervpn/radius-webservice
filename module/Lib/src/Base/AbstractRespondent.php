<?php
namespace Lib\Base;

//use Zend\Stdlib\Hydrator;

Abstract class AbstractRespondent
{
    /**
     * Web service error code
     */
    const ENTITY_NOT_FOUND           = '404';
    const ENTITY_ERROR               = '420';
    const ENTITY_ALREADY_EXIST       = '421';
    const ENTITY_CREATED             = '201';

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
