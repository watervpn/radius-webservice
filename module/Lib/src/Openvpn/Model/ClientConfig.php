<?php
namespace Lib\Openvpn\Model;

use Lib\Base\AbstractModel;
use Lib\Openvpn\Model\ServerStatus;
use Lib\Base\Exception as Exception;

/**
 * Business rules for the ClientConfig 
 */
class ClientConfig extends AbstractModel
{
    private $clientParam;
    private $buildConfigWorker;

    public function __construct($mapper, $clientParam)
    {
        parent::__construct($mapper);
        $this->clientParam       = $clientParam;
    }

    /**
     * file path to client config template
     */
    private static function getConfigPath()
    {
        return __DIR__.'/../Util/ConfigTemplate/client-config.ovpn';
    }

    /**
     * get client config tempalte
     */
    public static function getConfigTemplate($overwrite = 'default'){
        // TODO: 
        // get default template 
        // overlay example: ca1, us1 or ca, us, xxx schema
        // if overlay not default, get the set of server array and overwrite on default template
        //return $config = file_get_contents(self::CONFIG_TEMPLATE_FILE);
        return $config = file_get_contents( self::getConfigPath() );
    }

    //http://stackoverflow.com/questions/3191131/read-edit-save-config-files-php

}
