<?php
//we create ServiceManagerGrabber class later...
//https://samsonasik.wordpress.com/2013/11/19/zendframework-2-centralize-phpunit-test/
use ModulesTests\ServiceManagerGrabber; 
 
error_reporting(E_ALL | E_STRICT);
 
$cwd = __DIR__;
chdir(dirname(__DIR__));
 
// Assume we use composer
$loader = require_once  './vendor/autoload.php';
$loader->add("ModulesTests\\", $cwd);
$loader->register();
 
ServiceManagerGrabber::setServiceConfig(require_once './config/application.config.php');
ob_start();
