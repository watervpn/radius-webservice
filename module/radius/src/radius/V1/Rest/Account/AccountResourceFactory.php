<?php
namespace radius\V1\Rest\Account;

class AccountResourceFactory
{
    public function __invoke($services)
    {
        //return new AccountResource();
        return new AccountResource($services->get('radius\V1\Rest\Account\AccountMapper'));
    }
}
