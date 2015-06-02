<?php
namespace Lib\Radius\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Lib\Model\AbstractMapper;
use Lib\Model\Exception as Exception;

class CheckMapper extends AbstractMapper
{
    /**
     * Overwrite MapperAbstract primaryKey 
     * The db primary key's column name 
     */
    protected $primaryKey = 'id';
    
    /**
     * Find row by username
     */
    public function findByUser($username)
    {
        $attribute = 'User-Password';
        $rowset = $this->tableGateway->select(array('username' => $username, 'attribute' => $attribute));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception\MapperException("Could not find row: [$username]");
        }
        return $row;
    }

}
