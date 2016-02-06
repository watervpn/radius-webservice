<?php
//require_once('lib_autoloader.php');
require_once('Bootstrap.php');

try{
    echo "<br/>start<br/>";

    $testMapper = $sm->get('Lib\Radius\Mapper\Check'); 
    $obj = $testMapper->findByUser('roy');
    $obj = $obj->current();
    var_dump($obj);

    echo "<br/>end<br/>";
}catch(Exception $e){
    echo $e;
}
