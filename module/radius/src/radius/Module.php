<?php
namespace radius;

use ZF\Apigility\Provider\ApigilityProviderInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use radius\V1\Rest\Account\CheckMapper;
use radius\V1\Rest\Account\CheckEntity;

class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'ZF\Apigility\Autoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'radius\V1\Rest\Account\AccountMapper' =>  function ($sm) {
                    //$adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $adapter = $sm->get('Db\Radius_test');
                    $checkMapper = $sm->get('radius\V1\Rest\Account\CheckMapper');
                    return new \radius\V1\Rest\Account\AccountMapper($adapter, $checkMapper);
                },
                'radius\V1\Rest\Account\CheckMapper' =>  function ($sm) {
                    $tableGateway = $sm->get('CheckTableGateway');
                    $table = new CheckMapper($tableGateway);
                    return $table;
                },
                'CheckTableGateway' =>  function ($sm) {
                    $adapter = $sm->get('Db\Radius_test');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new CheckEntity() );
                    return new TableGateway('radcheck', $adapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
