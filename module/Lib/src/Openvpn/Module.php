<?php
use Lib\Openvpn as Openvpn;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

return array(
    'factories' => array(
        /*
         * TableGateway
         */
        // ClientKey Tablegateway
        'Lib\Openvpn\TableGateway\ClientKey' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $model = $sm->get('\Lib\Openvpn\Model\ClientKey');
            $resultSetPrototype->setArrayObjectPrototype($model);
            return new TableGateway('opvn_client_key', $adapter, null, $resultSetPrototype);
        },
        // ClientParam Tablegateway
        'Lib\Openvpn\TableGateway\ClientParam' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $model = $sm->get('\Lib\Openvpn\Model\ClientParam');
            $resultSetPrototype->setArrayObjectPrototype($model);
            return new TableGateway('opvn_client_param', $adapter, null, $resultSetPrototype);
        },
        // ClientConfig Tablegateway
        'Lib\Openvpn\TableGateway\ClientConfig' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $model = $sm->get('\Lib\Openvpn\Model\ClientConfig');
            $resultSetPrototype->setArrayObjectPrototype($model);
            return new TableGateway('opvn_client_config', $adapter, null, $resultSetPrototype);
        },
        // ServerStatus Tablegateway
        'Lib\Openvpn\TableGateway\ServerStatus' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $model = $sm->get('\Lib\Openvpn\Model\ServerStatus');
            $resultSetPrototype->setArrayObjectPrototype($model);
            return new TableGateway('opvn_server_status', $adapter, null, $resultSetPrototype);
        },

        /*
         * Mapper 
         */
        // ClientKeyMapper
        'Lib\Openvpn\Mapper\ClientKey' =>  function ($sm) {
            $tableGateway = $sm->get('Lib\Openvpn\TableGateway\ClientKey');
            return new Openvpn\Mapper\ClientKey($tableGateway);
        },
        // ClientConfigMapper
        'Lib\Openvpn\Mapper\ClientConfig' =>  function ($sm) {
            $tableGateway = $sm->get('Lib\Openvpn\TableGateway\ClientConfig');
            return new Openvpn\Mapper\ClientConfig($tableGateway);
        },
        // ClientParamMapper
        'Lib\Openvpn\Mapper\ClientParam' =>  function ($sm) {
            $tableGateway = $sm->get('Lib\Openvpn\TableGateway\ClientParam');
            return new Openvpn\Mapper\ClientParam($tableGateway);
        },
        // ServerStatusMapper
        'Lib\Openvpn\Mapper\ServerStatus' =>  function ($sm) {
            $tableGateway = $sm->get('Lib\Openvpn\TableGateway\ServerStatus');
            return new Openvpn\Mapper\ServerStatus($tableGateway);
        },

        /*
         * Model 
         */
        // ClientKey Model
        'Lib\Openvpn\Model\ClientKey' =>  function ($sm) {
            return new Openvpn\Model\ClientKey();
        },
        // ClientConfig Model
        'Lib\Openvpn\Model\ClientConfig' =>  function ($sm) {
            $clientKey    = $sm->get('Lib\Openvpn\Model\ClientKey');
            $clientParam  = $sm->get('Lib\Openvpn\Model\ClientParam');
            return new Openvpn\Model\ClientConfig($clientKey, $clientParam);
        },
        // ClientParam Model
        'Lib\Openvpn\Model\ClientParam' =>  function ($sm) {
            return new Openvpn\Model\ClientParam();
        },
        // ServerStatus Model
        'Lib\Openvpn\Model\ServerStatus' =>  function ($sm) {
            return new Openvpn\Model\ServerStatus();
        },


        /*
         * Service 
         */
         // Client Config Service
        'Lib\Openvpn\Service\ClientConfig' =>  function ($sm) {
            $clientConfig = $sm->get('Lib\Openvpn\Model\ClientConfig');
            return new Openvpn\Service\ClientConfig($clientConfig);
        },
        // Server Status Service
        'Lib\Openvpn\Service\ServerStatus' =>  function ($sm) {
            $serverStatus       = $sm->get('Lib\Openvpn\Model\ServerStatus');
            $serverStatusWorker = $sm->get('Lib\Openvpn\Worker\FetchAllServerStatus');
            return new Openvpn\Service\ServerStatus($serverStatus, $serverStatusWorker);
        },

        /*
         * Worker 
         */
         // FetchAllServerStatus
        'Lib\Openvpn\Worker\FetchAllServerStatus' =>  function ($sm) {
            $serverStatusModel = $sm->get('Lib\Openvpn\Model\ServerStatus');
            return new Openvpn\Worker\FetchAllServerStatus($serverStatusModel);
        },

    ),
);
