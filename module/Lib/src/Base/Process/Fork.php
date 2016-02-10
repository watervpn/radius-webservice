<?php
require_once('Bootstrap.php');

// Get pass-in Multiprocess Object
$multiProcess = $argv[1];
$multiProcess = unserialize(base64_decode($multiProcess));

// Fork each single process contain in multiprocess
foreach( $multiProcess->getProcesses() as $name => $process ){

    // Fork process
    $pid = pcntl_fork();

    if($pid == -1) {
        // TODO: throw exception
        exit("Error forking...\n");
    }
    // In child process
    else if($pid == 0) {
        /**
         * Set the Process title
         * Terminal Command to check process
         * ps -ef | grep "Frok Process" 
         */
        $class = get_class($process);
        cli_set_process_title("Fork Process CLASS:[{$class}] - NAME:[{$name}].");

        try{
            $process->run();
        }catch(Exception $e){
            //echo "Executing process [$name]\r\n";
            //logs
        }
        exit();
    }
}
