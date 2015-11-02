<?php
namespace Lib\Openvpn\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Lib\Base\AbstractMapper;
use Lib\Base\Exception as Exception;

class ClientKey extends AbstractMapper
{
    /**
     * Overwrite MapperAbstract primaryKey 
     * The db primary key's column name 
     */
    protected $primaryKeys = array('id');

    /**
     * Find row by account
     *
     * @return Zend\Db\ResultSet\ResultSet
     */
    public function findByAccount($account)
    {
        //$attribute = 'User-Password';
        $rowset = $this->tableGateway->select(array('account' => $account));
        //$row = $rowset->current();
        if ($rowset->count() <= 0) {
            throw new Exception\ObjectNotFoundException(__CLASS__." Could not find row: [$account]");
        }
        return $rowset->current();
    }

}
