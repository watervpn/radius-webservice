<?php
namespace Lib;

/*use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Lib\Radius as Radius;
use Lib\Openvpn as Openvpn;*/

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

    public function getOpenvpnConfig()
    {
        return include __DIR__ . '/src/Openvpn/Module.php';
    }

    public function getRadiusConfig()
    {
        return include __DIR__ . '/src/Radius/Module.php';
    }
    public function getServiceConfig()
    {
        //return array(
        $default = array(
            'factories' => array(
                /*
                 * Data source
                 */
                // Radius db Abstract
                'Db\Radius' => function ($sm) {
                    return $sm->get('radius_prod');
                },
                // Webservice db Abstract
                'Db\Webservice' => function ($sm) {
                    return $sm->get('webserver_prod');
                },

            ),
        );

        //return array_merge($default, $this->getOpenvpnConfig());
        return array_merge_recursive(
            $default, 
            $this->getRadiusConfig(),
            $this->getOpenvpnConfig()
        );
    }
}
