<?php
require_once(__DIR__.'/../../../../../public/Bootstrap.php');
//require_once('Bootstrap.php');

/**
 * Error logging
 *
 * default error log path for process "/var/log/httpd/error_log"
 * to change error log path:
 * ini_set('error_log', "/var/www/vhosts/dev/api-test/logs/error_log");
 */

// Get pass-in Multiprocess Object
$multiProcess = $argv[1];
$multiProcess = unserialize(base64_decode($multiProcess));

// Fork each single process contain in multiprocess
foreach( $multiProcess->getProcesses() as $name => $process ){

    // Inject service manager to each process
    $process->setServiceManager($sm);

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
         * ps -ef | grep "Fork Process"
         * watch 'ps -ef | grep "Fork Process"'
         */
        $class = get_class($process);
        cli_set_process_title("Fork Process CLASS:[{$class}] - NAME:[{$name}].");

        try{
            $process->run();
        }catch(Exception $e){
            throw $e;
            //echo "Executing process [$name]\r\n";
        }
        exit();
    }
}
