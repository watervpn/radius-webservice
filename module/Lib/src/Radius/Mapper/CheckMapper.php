<?php
namespace Lib\Radius\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Lib\Model\AbstractMapper;

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
        $rowset = $this->tableGateway->select(array('username' => $username));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

}
