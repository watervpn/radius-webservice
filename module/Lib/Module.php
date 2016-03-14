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
            'initializers' => array(               
                /*
                 * Init static service manager, so we can get service anywhere
                 */
                'ObjectHelper' => function($service, $sm) {
                    // inject service manager  only when controllerManager get call
                    if($service instanceof \Zend\Mvc\Controller\ControllerManager){
                        \Lib\ServiceManager::setServiceManager($sm);
                    }
                }
            ),

        );

        $init = array(
        );

        //return array_merge($default, $this->getOpenvpnConfig());
        return array_merge_recursive(
            $default, 
            $this->getRadiusConfig(),
            $this->getOpenvpnConfig()
        );
    }
}
