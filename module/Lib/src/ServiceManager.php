<?php
namespace Lib;

class ServiceManager
{
    protected static $serviceManager;
    // cache mapper creation
    protected static $mappers;

    function __construct ()
    {
    }

    public static function setServiceManager($sm)
    {
        static::$serviceManager = $sm;
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    public static function get($serviceName)
    {
        return static::getServiceManager()->get($serviceName);
    }

    public static function getModel($module, $class)
    {
        $serviceName = "Lib\\$module\\Model\\".$class;
        return static::getServiceManager()->get($serviceName);
    }

    public static function getMapper($module, $class)
    {
        $serviceName = "Lib\\$module\\Mapper\\".$class;
        if(!isset(static::$mappers[$serviceName])){
            static::$mappers[$serviceName] = static::getServiceManager()->get($serviceName);
        }
        return static::$mappers[$serviceName];
    }

    public static function getEntity($module, $class)
    {
        $serviceName = "Lib\\$module\\Entity\\".$class;
        return static::getServiceManager()->get($serviceName);
    }

    public static function getService($module, $class)
    {
        $serviceName = "Lib\\$module\\Service\\".$class;
        return static::getServiceManager()->get($serviceName);
    }
    
}
