<?php
namespace Lib;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Lib\Radius as Radius;

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
                /*
                 * Data source
                 */
                // Radius db Abstract
                'Db\Radius' => function ($sm) {
                    return $sm->get('radius_prod');
                },

                /*
                 * Mapper - tablegateway
                 */
                // CheckMapper
                'Lib\Radius\Mapper\Check' =>  function ($sm) {
                    $tableGateway = $sm->get('Lib\Radius\TableGateway\Check');
                    return new Radius\Mapper\Check($tableGateway);
                },
                'Lib\Radius\TableGateway\Check' =>  function ($sm) {
                    $adapter = $sm->get('Db\Radius');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Radius\Model\Check() );
                    return new TableGateway('radcheck', $adapter, null, $resultSetPrototype);
                },
                // ReplyMapper
                'Lib\Radius\Mapper\Reply' =>  function ($sm) {
                    $tableGateway = $sm->get('Lib\Radius\TableGateway\Reply');
                    return new Radius\Mapper\Reply($tableGateway);
                },
                'Lib\Radius\TableGateway\Reply' =>  function ($sm) {
                    $adapter = $sm->get('Db\Radius');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Radius\Model\Reply() );
                    return new TableGateway('radreply', $adapter, null, $resultSetPrototype);
                },
                // GroupCheckMapper
                'Lib\Radius\Mapper\GroupCheck' =>  function ($sm) {
                    $tableGateway = $sm->get('Lib\Radius\TableGateway\GroupCheck');
                    return new Radius\Mapper\GroupCheck($tableGateway);
                },
                'Lib\Radius\TableGateway\GroupCheck' =>  function ($sm) {
                    $adapter = $sm->get('Db\Radius');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Radius\Model\GroupCheck() );
                    return new TableGateway('radgroupcheck', $adapter, null, $resultSetPrototype);
                },
                // GroupReplyMapper
                'Lib\Radius\Mapper\GroupReply' =>  function ($sm) {
                    $tableGateway = $sm->get('Lib\Radius\TableGateway\GroupReply');
                    return new Radius\Mapper\GroupReply($tableGateway);
                },
                'Lib\Radius\TableGateway\GroupReply' =>  function ($sm) {
                    $adapter = $sm->get('Db\Radius');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Radius\Model\GroupReply() );
                    return new TableGateway('radgroupreply', $adapter, null, $resultSetPrototype);
                },
                // UserGroupMapper
                'Lib\Radius\Mapper\UserGroup' =>  function ($sm) {
                    $tableGateway = $sm->get('Lib\Radius\TableGateway\UserGroup');
                    return new Radius\Mapper\UserGroup($tableGateway);
                },
                'Lib\Radius\TableGateway\UserGroup' =>  function ($sm) {
                    $adapter = $sm->get('Db\Radius');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Radius\Model\UserGroup() );
                    return new TableGateway('radusergroup', $adapter, null, $resultSetPrototype);
                },

                /*
                 * Mapper - composite of sub mappers
                 */
                // AccountMapper 
                'Lib\Radius\Mapper\Account' =>  function ($sm) {
                    //$adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $adapter = $sm->get('Db\Radius');
                    $entity = new Radius\Model\Account();
                    $checkMapper = $sm->get('Lib\Radius\Mapper\Check');
                    $groupMapper = $sm->get('\Lib\Radius\Mapper\UserGroup');
                    $groupCheckMapper = $sm->get('\Lib\Radius\Mapper\GroupCheck');
                    return new Radius\Mapper\Account($adapter, $entity, $checkMapper, $groupMapper, $groupCheckMapper);
                },

                /*
                 * Web Service Respondent 
                 */
                'Lib\Radius\Respondent\Account' =>  function ($sm) {
                    $accountMapper = $sm->get('\Lib\Radius\Mapper\Account');
                    return new Radius\Respondent\Account($accountMapper);
                },
            ),
        );
    }
}
