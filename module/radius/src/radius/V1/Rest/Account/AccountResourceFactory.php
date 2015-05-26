<?php
namespace radius\V1\Rest\Account;

// test use
use Zend\Stdlib\Hydrator;

class AccountResourceFactory
{
    public function __invoke($services)
    {
        // testing -- remove
        //$checkMapper = $services->get('radius\V1\Rest\Account\CheckMapper');
        //$check = $checkMapper->findByUser('ming');
        //$check->setValue("asdfasdfa");
        //print_r($check);
        //$checkMapper->save($check);

        // Test Start
        /*$hydrator = new Hydrator\ClassMethods();
        $check = new \Lib\Radius\Entity\CheckEntity('1', 'apple', 'attr', '=', 'password');
        $arrayCheck = $hydrator->extract($check);

        $newCheck = new \Lib\Radius\Entity\CheckEntity();
        $objCheck = $hydrator->hydrate($arrayCheck['array_copy'], $newCheck);
        $objCheck->setValue('changed');
        print_r($arrayCheck);
        var_dump($objCheck);*/

        //$test = new \Lib\Radius\Entity\TestEntity('1', 'apple', 'attr', '=', 'password');
        //$test->setValue('ivalue');
        //$array = $test->getArrayCopy();
        //print_r($array);

        //$testMapper = $services->get('Lib\Radius\TestMapper');
        //$testObj = $testMapper->findByUser('ming');
        //print_r($testObj);
        //$testObj->setValue('something');
        //print_r($testObj);
        //$testMapper->save($testObj);

        // Test End
        
        //return new AccountResource();
        return new AccountResource($services->get('Radius\Account\AccountMapper'));

    }
}
