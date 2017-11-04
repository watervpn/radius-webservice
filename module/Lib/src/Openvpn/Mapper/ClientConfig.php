<?php
namespace Lib\Openvpn\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Lib\Base\AbstractMapper;
use Lib\Base\Exception as Exception;

class ClientConfig extends AbstractMapper
{
    /**
     * Overwrite MapperAbstract primaryKey 
     * The db primary key's column name 
     */
    protected $primaryKeys = array('account_id');

    /**
     * Find row by account
     *
     * @return Zend\Db\ResultSet\ResultSet
     */
    /*public function findByAccount($accountId)
    {
        $rowset = $this->tableGateway->select(array('account_id' => $accountId));
        if ($rowset->count() <= 0) {
            throw new Exception\ObjectNotFoundException(__CLASS__." Could not find row: [$accountId]");
        }
        return $rowset;
    }*/

    /**
     * Find row by server
     *
     * @return Zend\Db\ResultSet\ResultSet
     */
    /*public function findByServer($server)
    {
        $rowset = $this->tableGateway->select(array('server' => $server));
        if ($rowset->count() <= 0) {
            throw new Exception\ObjectNotFoundException(__CLASS__." Could not find row: [$server]");
        }
        return $rowset;
    }*/
}
