<?php
namespace radius\V1\Rest\Account;

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

        
        //return new AccountResource();
        return new AccountResource($services->get('radius\V1\Rest\Account\AccountMapper'));

    }
}
