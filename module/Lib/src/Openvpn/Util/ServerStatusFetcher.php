<?php
namespace Lib\Openvpn\Util;

use phpseclib\Crypt\RSA; 
use phpseclib\Net\SSH2;
/**
 * Remote client config
 * Deply phpseclib run:
 * php composer.phar update phpseclib/phpseclib
 * //http://unix.stackexchange.com/questions/69167/bash-script-that-print-cpu-usage-diskusage-ram-usage
 */
class ServerStatusFetcher
{
    private $ssh;
    private $host;

    public function __construct($host)
    {
        $this->host = $host;
        $this->ssh  = new SSH2($this->host); 
        $key        = new RSA();
        $user       = 'wvpn';
        // load private from apache home ssh dir
        $key->loadKey(file_get_contents('/var/www/.ssh/file.rsa'));
        if (!$this->ssh->login($user, $key)) {
            exit('Login Failed');
        }
    }

    private function cmdException($op, $fn)
    {
        throw new \Exception(__CLASS__ ." : ". $fn ." Error: unexpected remote cmd output Exception: host[{$this->host}] op:[".print_r($op, true)."]");
    }

    /**
     * Execute remote linux command
     */
    private function run( $cmd )
    {
        $cmd = "$cmd 2>&1";
        // split output into array new new line
        $op  = explode( PHP_EOL, $this->ssh->exec($cmd) );
        // remove extra new line at the end of output
        array_pop($op);
        return $op;
    }

    /**
     * Get current total users on VPN server
     * @return Int
     */
    public function getUserCount()
    {
        ///etc/openvpn/openvpn.log
        // Check openvpn status log for active client count
        $cmd = "cat /etc/openvpn/openvpn-status.log | egrep -c '^client'";
        $op  = $this->run( $cmd );
        if( count($op) == 1 && is_numeric($op[0]) ){
            return $op[0];
        }else{
            $this->cmdException($op, __FUNCTION__);
        }
    }

    /**
     * Get current users info on VPN server
     * @return array of users info
     */
    public function getUsers()
    {
        // Check openvpn status log for active client info
        $cmd = "cat /etc/openvpn/openvpn-status.log | egrep '^client'";
        $op  = $this->run( $cmd );
        $users = [];
        if( count($op) > 0 ){
            foreach($op as $index => $user){
                $users[] = explode(',', $user);
            }
        }
        return $users;
    }

    /**
     * Get Upload & Download Speed from host
     * @return array($uploadSpeed, $downloadSpeed)
     */
    public function getBandwidth($eth = "ens32", $secs = 1)
    {
        $sleep   = "sleep $secs";
        // Upload bytes
        $txCmd   = "cat /sys/class/net/{$eth}/statistics/tx_bytes";
        // Download bytes
        $rxCmd   = "cat /sys/class/net/{$eth}/statistics/rx_bytes";
        // Get the upload & downlaod before and after 1 second
        $op = $this->run( $txCmd." && ".$rxCmd." && ".$sleep." && ".$txCmd." && ".$rxCmd );
        
        if(count($op) == 4){
            // Kb(Kilo Bit) / Second
            /*$downloadSpeed = (($op[2] - $op[0]) * 8 / 1000) /$secs;
            $uploadSpeed   = (($op[3] - $op[1]) * 8 / 1000) /$secs;*/
            // KB(Kilo Bytes) / Second
            $downloadSpeed = (($op[2] - $op[0]) / 1000) / $secs;
            $uploadSpeed   = (($op[3] - $op[1]) / 1000) / $secs;
            return array($uploadSpeed, $downloadSpeed);
        }else{
            $this->cmdException($op, __FUNCTION__);
        }
    }

    /**
     * Get current cpu  usage from host
     * @return array($cpu, $memory)
     */
    public function getCpu()
    {
        $cmd = "top -b -n1 | grep 'Cpu(s)' | awk '{print $2 + $4}'";
        // cat /proc/meminfo | egrep '^(MemTotal|MemFree)'
        $op  = $this->run( $cmd );
        if(count($op) == 1){
            return $op[0];
        }else{
            $this->cmdException($op, __FUNCTION__);
        }
    }

    /**
     * Get current  memory usage from host
     * @return array($cpu, $memory)
     */
    public function getMemory()
    {
        $cmd = "free -m | grep Mem";
        // cat /proc/meminfo | egrep '^(MemTotal|MemFree)'
        $op  = $this->run( $cmd );
        if(count($op) == 1){
            $op = preg_split('/\s+/', $op[0]);
            $memUsed = round( ($op[2] / $op[1]) * 100, 1 );
            return $memUsed;
        }else{
            $this->cmdException($op, __FUNCTION__);
        }
    }

}
