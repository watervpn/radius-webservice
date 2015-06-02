<?php
namespace Lib\Model;

use Zend\Stdlib\Hydrator;

Abstract class AbstractEntity
{

    public function __construct(){
    }

    /**
     * Convert array to object
     *
     * @param array
     */
    abstract public function exchangeArray(array $data);
    
    /**
     * Convert object to array
     *
     * @return array
     */
    abstract public function getArrayCopy();
}
