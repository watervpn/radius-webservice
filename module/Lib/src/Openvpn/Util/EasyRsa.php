<?php
namespace Lib\Openvpn\Util;

use Lib\Base\AbstractEntity;
/**
 * Build and revoke EasyRsa keys
 */
class EasyRsa
{
    // user worker to do the create get delete process & save to database
    // Worker/generateClientRsa
    // can't generate same client key
    // http://blog.kenyap.com.au/2012/07/txtdb-error-number-2-when-generating.html
    private static function getPath()
    {
        return __DIR__.'/../Bin';
    }

    /**
     * change to bin location and reload vars env var
     */
    private static function cmdPrefix()
    {
        return 'cd '.self::getPath().' && source ./vars && ';
    }

    /**
     * @param string filename / userId
     */
    public static function build($filename)
    {
        // do db check before call create
        // failed to update database
        // TXT_DB error number 2
        // success
        // 2>&1 redirect 'stderr' to 'stdout' to get all output in $op var
        $command = sprintf('%s ./build-key --batch %s 2>&1', self::cmdPrefix(), $filename);
        exec($command ,$op, $return);
        // exec: return 0 when command ran successfully
        if( $return !== 0 ){
            throw new \Exception("Error generate openvpn client key filename: $filename Exception".print_r($op, true));
        }
        // exec: oupout 'Data Base Updated' at the end of the line when key generate successfully
        if( strstr(end($op), 'Data Base Updated') == false ){
            throw new \Exception("Error: KEY_CN has to be unique, please use other filename or use revoke-full to update db - filename: $filename Exception: ". print_r($op, true));
        }
        return $op;
    }

    /**
     * Revoke crts and update easyRsa databases
     */
    public static function revoke($filename)
    {
        // command ./revoke-full client-test12
        $command = sprintf('%s ./revoke-full %s 2>&1', self::cmdPrefix(), $filename);
        exec($command ,$op, $return);
        return $op;
    }

    /**
     * Delete crts
     */
    public static function delete($filename)
    {
        // Remove key files
        $command = sprintf('rm -rf %s/keys/%s.key %s/keys/%s.crt %s/keys/%s.csr 2>&1', self::getPath(), $filename, self::getPath(), $filename, self::getPath(), $filename);
        exec($command ,$op, $return);
        if( $return !== 0 ){
            throw new \Exception("Error delete openvpn client key filename: $filename Exception".print_r($op, true));
        }
        // Remove pem files
        self::deletePermFiles();
        return $op;
    }

    /**
     * Delete all perm (except crl.pem file)
     * Each client key creation generate new perm file, and we don't need to keep this file
     */
    public static function deletePermFiles()
    {
        $pemFiles = glob( sprintf('%s/keys/*.pem', self::getPath()) ); 
        $keepPemFile =  array_search( self::getPath().'/keys/crl.pem', $pemFiles );
        // remove keepPemFile from delete's list
        unset($pemFiles[$keepPemFile]);

        foreach($pemFiles as $pemFile){
            unlink($pemFile);
        }
    }

    /**
     * Get generate key (crt, key, csr)
     */
    public static function getKeys($filename)
    {
        $crt = self::getKey($filename, 'crt');
        $key = self::getKey($filename, 'key');
        $csr = self::getKey($filename, 'csr');
        return array('crt'=>$crt, 'key'=>$key, 'csr'=>$csr);
    }

    /**
     * check if all keys exist (crt, key, csr)
     */
    public static function isKeyExist($filename)
    {
        @$keys = self::getKeys($filename);
        if(in_array(true, $keys)){
            return true;
        }
        return false;
    }

    /**
     * Get individual key
     */
    public static function getKey($filename, $ext)
    {
        return file_get_contents( self::getPath()."/keys/$filename.$ext" );
    }

}
