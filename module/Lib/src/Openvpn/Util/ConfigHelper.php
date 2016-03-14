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
        $key     = preg_quote($key, '/');
        //preg_match("/[^;]{$key}\s(.*)/", $config, $matches);
        preg_match("/\r\n{$key}\s(.*)/", $config, $matches);
        //preg_match("/\n{$key}\s(.*)/", $config, $matches);
        
        // Add if key not found in config
        if(empty($matches)){
            $strpos = strpos($config ,'<ca>');
            $config = substr_replace($config, "{$key} {$value}\r\n", $strpos - 1, 0 );
            return $config;
        }

        $pattern = "/(\r\n{$key}\s)(.*)/";
        $config = preg_replace($pattern, '${1}'.$value, $config);
        return $config;
    }

    public static function replaceKey($type, $key, $config)
    {
        //$type     = preg_quote($type, '/');
        $allowTypes = array ('cert', 'key', 'ca');
        if(!in_array($type, $allowTypes)){
            return;
        }
        $matches = array();
        //preg_match("/<{$type}>(.*)<\/{$type}>/s", $config, $matches);
        preg_match("/<{$type}>\r\n(.*)\r\n<\/{$type}>/s", $config, $matches);
        return $config = str_replace($matches[1], $key, $config);
    }
}
