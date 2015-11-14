<?php
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

error_reporting(E_ALL | E_STRICT);
 
$cwd = __DIR__;
chdir(dirname(__DIR__));
 
// Include composer autoloader
$loader = require_once  __DIR__.'/../vendor/autoload.php';

// Load Zend service manager
$configuration = require_once __DIR__.'/../config/application.config.php';
$smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : array();
$sm = new ServiceManager(new ServiceManagerConfig($smConfig));
$sm->setService('ApplicationConfig', $configuration);
$sm->get('ModuleManager')->loadModules();

ob_start();

