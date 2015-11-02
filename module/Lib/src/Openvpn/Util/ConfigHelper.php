<?php
namespace Lib\Openvpn\Util;

use Lib\Base\AbstractEntity;
/**
 * Manipulate client config
 */
class ConfigHelper
{
    public static function replaceConfig($key, $value, $config)
    {
        //$content = file_get_contents($file);
        $key     = preg_quote($key, '/');
        //$matches = array();
        preg_match("/{$key}\s(.*)/", $content, $matches);
        $config = str_replace($matches[1], $value, $content);
        return $config;
        //file_put_contents($file, $content);
    }

    public static function replaceKey($type, $key, $config)
    {
        //$type     = preg_quote($type, '/');
        $allowTypes = array ('cert', 'key', 'ca');
        if(!in_array($type, $allowTypes)){
            return;
        }
        $matches = array();
        preg_match("/<{$type}>(.*)<\/{$type}>/s", $config, $matches);
        return $config = str_replace($matches[1], $key, $config);
    }
}
