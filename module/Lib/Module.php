<?php
namespace Lib;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Lib\Radius\Mapper\CheckMapper;
use Lib\Radius\Entity\CheckEntity;
use Lib\Radius\Mapper\ReplyMapper;
use Lib\Radius\Entity\ReplyEntity;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/'
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                // Radius db Abstract
                'Db\Radius' => function ($sm) {
                    return $sm->get('Db\Radius_test');
                },

                // CheckMapper
                'Lib\Radius\CheckMapper' =>  function ($sm) {
                    $tableGateway = $sm->get('Lib\Radius\CheckTableGateway');
                    $table = new CheckMapper($tableGateway);
                    return $table;
                },
                'Lib\Radius\CheckTableGateway' =>  function ($sm) {
                    $adapter = $sm->get('Db\Radius');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new CheckEntity() );
                    return new TableGateway('radcheck', $adapter, null, $resultSetPrototype);
                },

                // ReplyMapper
                'Lib\Radius\ReplyMapper' =>  function ($sm) {
                    $tableGateway = $sm->get('Lib\Radius\ReplyTableGateway');
                    $table = new CheckMapper($tableGateway);
                    return $table;
                },
                'Lib\Radius\ReplyTableGateway' =>  function ($sm) {
                    $adapter = $sm->get('Db\Radius');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ReplyEntity() );
                    return new TableGateway('radreply', $adapter, null, $resultSetPrototype);
                },
                
                // GroupCheckMapper
                // GroupReplyMapper
                // UserGroupMapper
            ),
        );
    }
}
