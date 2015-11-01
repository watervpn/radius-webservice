<?php

use Zend\ServiceManager\ServiceManager;

// custom to disalbe opcahce for admin interface
// remove the following line to prevent affect webservice
/*opcache_reset();
ini_set('opcache.enable', 0);*/

/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

/*// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}*/

if (!file_exists('vendor/autoload.php')) {
    throw new RuntimeException(
        'Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.'
    );
}

// Setup autoloading
include 'vendor/autoload.php';

if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', realpath(__DIR__ . '/../'));
}

$appConfig = include APPLICATION_PATH . '/config/application.config.php';

if (file_exists(APPLICATION_PATH . '/config/development.config.php')) {
    $appConfig = Zend\Stdlib\ArrayUtils::merge($appConfig, include APPLICATION_PATH . '/config/development.config.php');
}

// Some OS/Web Server combinations do not glob properly for paths unless they
// are fully qualified (e.g., IBM i). The following prefixes the default glob
// path with the value of the current working directory to ensure configuration
// globbing will work cross-platform.
if (isset($appConfig['module_listener_options']['config_glob_paths'])) {
    foreach ($appConfig['module_listener_options']['config_glob_paths'] as $index => $path) {
        if ($path !== 'config/autoload/{,*.}{global,local}.php') {
            continue;
        }
        $appConfig['module_listener_options']['config_glob_paths'][$index] = getcwd() . '/' . $path;
    }
}

// Init Service Manager
$smConfig = isset($appConfig['service_manager']) ? $appConfig['service_manager'] : array();
$sm = new ServiceManager(new Zend\Mvc\Service\ServiceManagerConfig($smConfig));
$sm->setService('ApplicationConfig', $appConfig);
$sm->get('ModuleManager')->loadModules();

