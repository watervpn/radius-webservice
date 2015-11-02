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

        /*
         * Model 
         */
        'Lib\Openvpn\Model\ClientKey' =>  function ($sm) {
            $clientKeyMapper = $sm->get('Lib\Openvpn\Mapper\ClientKey');
            $clientKeyModel  = new Openvpn\Model\ClientKey();
            $clientKeyModel->setMapper($clientKeyMapper);
            return $clientKeyModel;
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
    ),
);
