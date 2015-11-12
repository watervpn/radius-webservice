<?php
use Lib\Openvpn as Openvpn;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

return array(
    'factories' => array(
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

        /*
         * Model 
         */
        // ClientKey Model
        'Lib\Openvpn\Model\ClientKey' =>  function ($sm) {
            $clientKeyMapper = $sm->get('Lib\Openvpn\Mapper\ClientKey');
            $clientKeyModel  = new Openvpn\Model\ClientKey( $clientKeyMapper );
            return $clientKeyModel;
        },
        // ClientConfig Model
        'Lib\Openvpn\Model\ClientConfig' =>  function ($sm) {
            $clientConfigMapper = $sm->get('Lib\Openvpn\Mapper\ClientConfig');
            $buildConfigWorker = $sm->get('Lib\Openvpn\Worker\BuildClientConfig');
            $clientParamMapper = $sm->get('Lib\Openvpn\Mapper\ClientParam');
            $clientConfigModel  = new Openvpn\Model\ClientConfig($clientConfigMapper, $buildConfigWorker, $clientParamMapper);
            return $clientConfigModel;
        },
        // ClientParam Model
        'Lib\Openvpn\Model\ClientParam' =>  function ($sm) {
            $clientParamMapper = $sm->get('Lib\Openvpn\Mapper\ClientParam');
            $clientParamModel  = new Openvpn\Model\ClientParam($clientParamMapper);
            return $clientParamModel;
        },


        /*
         * Worker 
         */
         // BuildClientConfig
        'Lib\Openvpn\Worker\BuildClientConfig' =>  function ($sm) {
            $clientConfigMapper = $sm->get('Lib\Openvpn\Mapper\ClientConfig');
            $clientKeyMapper = $sm->get('Lib\Openvpn\Mapper\ClientKey');
            $clientParamMapper = $sm->get('Lib\Openvpn\Mapper\ClientParam');
            $clientKey = $sm->get('Lib\Openvpn\Model\ClientKey');
            $clientParam = $sm->get('Lib\Openvpn\Model\ClientParam');
            return new Openvpn\Worker\BuildClientConfig($clientConfigMapper, $clientKeyMapper, $clientParamMapper, $clientKey, $clientParam);
        },

        /*
         * TableGateway
         */
        // ClientKey Tablegateway
        'Lib\Openvpn\TableGateway\ClientKey' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Openvpn\Model\ClientKey() );
            return new TableGateway('opvn_client_key', $adapter, null, $resultSetPrototype);
        },
        // ClientConfig Tablegateway
        'Lib\Openvpn\TableGateway\ClientConfig' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Openvpn\Model\ClientConfig() );
            return new TableGateway('opvn_client_config', $adapter, null, $resultSetPrototype);
        },
        // ClientParam Tablegateway
        'Lib\Openvpn\TableGateway\ClientParam' =>  function ($sm) {
            $adapter = $sm->get('Db\Webservice');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Openvpn\Model\ClientParam() );
            return new TableGateway('opvn_client_param', $adapter, null, $resultSetPrototype);
        },
    ),
);
