<?php
namespace Lib\Base\Process;

use Lib\Base\Process\SingleProcess;

class MultiProcess
{
    /**
     * Store mutiple single process
     */
    protected $processes = [];
    /**
     * current working directory
     */
    protected $cwd = __DIR__;

    public function __construct( array $processes = [])
    {
    }

    public function addProcess( SingleProcess $process )
    {
        $this->processes[$process->getName()] = $process;
    }

    public function getProcess( $name )
    {
        return $this->processes[$name];
    }

    public function removeProcess( $name )
    {
        unset($this->processes[$name]);
    }

    public function getProcesses()
    {
        return $this->processes;
    }


    private function verify()
    {
        if(count($this->processes) > 0){
        }

        if(file_exists($this->cwd)){
            //throw exception
        }
    }

    /**
     * Execute process 
     *
     * @param array
     */
    public function run( $async = false)
    {
        $this->verify();
        return $this->doRun( $async );
    }

    /**
     * @param async: true (Not wait for response, return execution control back), false (wait for response)
     */
    public function doRun( $async )
    {
        // serialize obj to pass into php command script as argv
        $processes = base64_encode(serialize($this)); 
        if($async){
            // php cmd to Async, response  must not output back to php 
            // Redirect both stdout and stderr to /dev/null then put it to background 
            $command   = "php {$this->cwd}/Fork.php $processes > /dev/null 2>&1 &"; 
        }else{
            $command   = "php {$this->cwd}/Fork.php $processes"; 
        }
        exec($command, $op, $return);
        return $op;
        /*var_dump($op);
        var_dump($return);*/

    }


}
