<?php
use Lib\Openvpn as Openvpn;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

return array(
    'factories' => array(
        /*
         * TableGateway
         */
        'Lib\Openvpn\TableGateway\ClientKey' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Openvpn\Entity\ClientKey() );
            return new TableGateway('opvn_client_key', $adapter, null, $resultSetPrototype);
        },
        // ClientConfig Tablegateway
        'Lib\Openvpn\TableGateway\ClientConfig' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Openvpn\Entity\ClientConfig() );
            return new TableGateway('opvn_client_config', $adapter, null, $resultSetPrototype);
        },
        // ClientParam Tablegateway
        'Lib\Openvpn\TableGateway\ClientParam' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Openvpn\Entity\ClientParam() );
            return new TableGateway('opvn_client_param', $adapter, null, $resultSetPrototype);
        },
        // ServerStatus Tablegateway
        'Lib\Openvpn\TableGateway\ServerStatus' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Openvpn\Entity\ServerStatus() );
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
            $clientKeyMapper = $sm->get('Lib\Openvpn\Mapper\ClientKey');
            $clientKeyModel  = new Openvpn\Model\ClientKey( $clientKeyMapper );
            //todo
            //$clientKeyModel->getServiceManager($sm);
            return $clientKeyModel;
        },
        // ClientConfig Model
        'Lib\Openvpn\Model\ClientConfig' =>  function ($sm) {
            $clientConfigMapper = $sm->get('Lib\Openvpn\Mapper\ClientConfig');
            $clientParamMapper  = $sm->get('Lib\Openvpn\Mapper\ClientParam');
            //$buildConfigWorker  = $sm->get('Lib\Openvpn\Worker\BuildClientConfig');
            $clientConfigModel  = new Openvpn\Model\ClientConfig($clientConfigMapper, $clientParamMapper);
            return $clientConfigModel;
        },
        // ClientParam Model
        'Lib\Openvpn\Model\ClientParam' =>  function ($sm) {
            $clientParamMapper = $sm->get('Lib\Openvpn\Mapper\ClientParam');
            $clientParamModel  = new Openvpn\Model\ClientParam($clientParamMapper);
            return $clientParamModel;
        },
        // ServerStatus Model
        'Lib\Openvpn\Model\ServerStatus' =>  function ($sm) {
            $serverStatusMapper = $sm->get('Lib\Openvpn\Mapper\ServerStatus');
            $serverStatusModel  = new Openvpn\Model\ServerStatus($serverStatusMapper);
            return $serverStatusModel;
        },

        /*
         * Worker 
         */
         // GetClientConfig
        'Lib\Openvpn\Worker\GetClientConfig' =>  function ($sm) {
            $clientKey = $sm->get('Lib\Openvpn\Model\ClientKey');
            $clientParam = $sm->get('Lib\Openvpn\Model\ClientParam');
            $clientConfig = $sm->get('Lib\Openvpn\Model\ClientConfig');
            return new Openvpn\Worker\GetClientConfig($clientKey, $clientParam, $clientConfig);
        },
         // FetchAllServerStatus
        'Lib\Openvpn\Worker\FetchAllServerStatus' =>  function ($sm) {
            $serverStatusModel = $sm->get('Lib\Openvpn\Model\ServerStatus');
            return new Openvpn\Worker\FetchAllServerStatus($serverStatusModel);
        },

    ),
);
