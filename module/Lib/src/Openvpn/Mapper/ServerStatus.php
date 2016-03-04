<?php
namespace Lib\Openvpn\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Lib\Base\AbstractMapper;
use Lib\Base\Exception as Exception;

class ServerStatus extends AbstractMapper
{
    /**
     * Overwrite MapperAbstract primaryKey 
     * The db primary key's column name 
     */
    protected $primaryKeys = array('host');

}
