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
    public function run()
    {
        $this->verify();
        $this->doRun();
    }

    public function doRun()
    {
        // serialize obj to pass into php command script as argv
        $processes = base64_encode(serialize($this)); 
        $command   = "php {$this->cwd}/Fork.php $processes"; 
        exec($command, $op, $return);
        var_dump($op);
        var_dump($return);

    }


}
