<?php
namespace Lib\Openvpn\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Lib\Base\AbstractMapper;
use Lib\Base\Exception as Exception;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class ServerStatus extends AbstractMapper
{
    /**
     * Overwrite MapperAbstract primaryKey 
     * The db primary key's column name 
     */
    protected $primaryKeys = array('host');

    //overwrite save
    // clear region cache when everytime is save
    
    /**
     * Find row by region
     *
     * @return Zend\Db\ResultSet\ResultSet
     */
    public function findByRegion($region, $orderby=null, $sort=null, $offset = 0, $limit = 100)
    {
        //$rowset = $this->tableGateway->select(array('region' => $region));
        $rowset = $this->tableGateway->select(function (Select $select) use ($region, $orderby, $sort, $offset, $limit){
            $select->where(array('region' => $region));
            // order by clause
            if(!empty($orderby)){
                if(is_array($orderby)){
                    if(!empty($sort)){
                        $orderby[0] .= ' '.$sort;
                    }
                }else{
                    if(!empty($sort)){
                        $orderby .= ' '.$sort;
                    }
                }
                $select->order($orderby);
            }
            $select->limit(intval($limit))->offset(intval($offset));
        });
        return $rowset;
    }

    public function getRegions()
    {
        $sql    = $this->tableGateway->getSql();
        $select = $sql->select();
        $select->columns(array('region'));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results   = $statement->execute();
        $rowset = new ResultSet;
        return $rowset->initialize($results);
    }

    public function findByFilter($region, $totalUsers, $orderby=null, $sort=null, $offset = 0, $limit = 100)
    {
    }

}
