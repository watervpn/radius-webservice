<?php
namespace Lib\Radius\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Lib\Model\AbstractMapper;
use Lib\Model\Exception as Exception;

class ReplyMapper extends AbstractMapper
{
    /**
     * Overwrite MapperAbstract primaryKey 
     * The db primary key's column name 
     */
    protected $primaryKeys = array('id');

    /**
     * Find row by username
     *
     * @return Zend\Db\ResultSet\ResultSet
     */
    public function findByUser($username)
    {
        $rowset = $this->tableGateway->select(array('username' => $username));
        if ($rowset->count() <= 0) {
            throw new Exception\ObjectNotFoundException(__CLASS__." Could not find row: [$username]");
        }
        return $rowset;
    }

    /**
     * Find row by username and attribute
     *
     * @return Lib\Radius\Entity\ReplyEntity
     */
    public function findByUserAttrOp($username, $attribute, $op)
    {
        $rowset = $this->tableGateway->select(
            array('username' => $username, 'attribute' => $attribute, 'op' => $op)
        );
        $row = $rowset->current();
        if (!$row) {
            throw new Exception\ObjectNotFoundException(__CLASS__." Could not find row: username [$username] and attribute [$attribute]");
        }
        return $row;
    }
}
