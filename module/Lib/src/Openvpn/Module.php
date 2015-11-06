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

        /*
         * Model 
         */
        // ClientKey Model
        'Lib\Openvpn\Model\ClientKey' =>  function ($sm) {
            $clientKeyMapper = $sm->get('Lib\Openvpn\Mapper\ClientKey');
            $clientKeyModel  = new Openvpn\Model\ClientKey();
            $clientKeyModel->setMapper($clientKeyMapper);
            return $clientKeyModel;
        },
        // ClientConfig Model
        'Lib\Openvpn\Model\ClientConfig' =>  function ($sm) {
            $clientConfigMapper = $sm->get('Lib\Openvpn\Mapper\ClientConfig');
            $buildConfigWorker = $sm->get('Lib\Openvpn\Worker\BuildClientConfig');
            $clientConfigModel  = new Openvpn\Model\ClientConfig($clientConfigMapper, $buildConfigWorker);
            return $clientConfigModel;
        },


        /*
         * Worker 
         */
         // BuildClientConfig
        'Lib\Openvpn\Worker\BuildClientConfig' =>  function ($sm) {
            $clientConfigMapper = $sm->get('Lib\Openvpn\Mapper\ClientConfig');
            $clientKeyMapper = $sm->get('Lib\Openvpn\Mapper\ClientKey');
            $clientKey = $sm->get('Lib\Openvpn\Model\ClientKey');
            return new Openvpn\Worker\BuildClientConfig($clientConfigMapper, $clientKeyMapper, $clientKey);
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
    ),
);
