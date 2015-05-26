<?php
namespace Lib\Model;

use Zend\Stdlib\Hydrator;

Abstract class AbstractEntity
{

    public function __construct(){
    }

    abstract public function exchangeArray(array $data);
    abstract public function getArrayCopy();
}
