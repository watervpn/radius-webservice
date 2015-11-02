<?php
use Lib\Radius as Radius;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

return array(
    'factories' => array(
        /*
         * Mapper 
         */
        // CheckMapper
        'Lib\Radius\Mapper\Check' =>  function ($sm) {
            $tableGateway = $sm->get('Lib\Radius\TableGateway\Check');
            return new Radius\Mapper\Check($tableGateway);
        },
        // ReplyMapper
        'Lib\Radius\Mapper\Reply' =>  function ($sm) {
            $tableGateway = $sm->get('Lib\Radius\TableGateway\Reply');
            return new Radius\Mapper\Reply($tableGateway);
        },
        // GroupCheckMapper
        'Lib\Radius\Mapper\GroupCheck' =>  function ($sm) {
            $tableGateway = $sm->get('Lib\Radius\TableGateway\GroupCheck');
            return new Radius\Mapper\GroupCheck($tableGateway);
        },
        // GroupReplyMapper
        'Lib\Radius\Mapper\GroupReply' =>  function ($sm) {
            $tableGateway = $sm->get('Lib\Radius\TableGateway\GroupReply');
            return new Radius\Mapper\GroupReply($tableGateway);
        },
        // UserGroupMapper
        'Lib\Radius\Mapper\UserGroup' =>  function ($sm) {
            $tableGateway = $sm->get('Lib\Radius\TableGateway\UserGroup');
            return new Radius\Mapper\UserGroup($tableGateway);
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
         * Model 
         */

        /*
         * TableGateway
         */
        // Check Tablegateway
        'Lib\Radius\TableGateway\Check' =>  function ($sm) {
            $adapter = $sm->get('Db\Radius');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Radius\Model\Check() );
            return new TableGateway('radcheck', $adapter, null, $resultSetPrototype);
        },
        // Reply Tablegateway
        'Lib\Radius\TableGateway\Reply' =>  function ($sm) {
            $adapter = $sm->get('Db\Radius');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Radius\Model\Reply() );
            return new TableGateway('radreply', $adapter, null, $resultSetPrototype);
        },
        // GroupCheck Tablegateway
        'Lib\Radius\TableGateway\GroupCheck' =>  function ($sm) {
            $adapter = $sm->get('Db\Radius');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Radius\Model\GroupCheck() );
            return new TableGateway('radgroupcheck', $adapter, null, $resultSetPrototype);
        },
        // Groupreply Tablegateway
        'Lib\Radius\TableGateway\GroupReply' =>  function ($sm) {
            $adapter = $sm->get('Db\Radius');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Radius\Model\GroupReply() );
            return new TableGateway('radgroupreply', $adapter, null, $resultSetPrototype);
        },
        // UserGroup Tablegateway
        'Lib\Radius\TableGateway\UserGroup' =>  function ($sm) {
            $adapter = $sm->get('Db\Radius');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Radius\Model\UserGroup() );
            return new TableGateway('radusergroup', $adapter, null, $resultSetPrototype);
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
