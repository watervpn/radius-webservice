<?php
require_once('lib_autoloader.php');

try{
    echo "<br/>start<br/>";

    $testMapper = $sm->get('Lib\Radius\CheckMapper'); 
    $obj = $testMapper->findByUser('roy');
    print_r($obj);

    echo "<br/>end<br/>";
}catch(Exception $e){
    echo $e;
}
