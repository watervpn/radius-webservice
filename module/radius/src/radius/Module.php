<?php
namespace radius;

use ZF\Apigility\Provider\ApigilityProviderInterface;

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
        /*return array(
            'factories' => array(
                'Radius\Account\AccountMapper' =>  function ($sm) {
                    //$adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $adapter = $sm->get('Db\Radius');
                    $checkMapper = $sm->get('Lib\Radius\Mapper\Check');
                    $groupMapper = $sm->get('\Lib\Radius\Mapper\UserGroup');
                    $groupCheckMapper = $sm->get('\Lib\Radius\Mapper\GroupCheck');
                    return new \radius\V1\Rest\Account\AccountMapper($adapter, $checkMapper, $groupMapper, $groupCheckMapper);
                },
            ),
        );*/
    }
}
