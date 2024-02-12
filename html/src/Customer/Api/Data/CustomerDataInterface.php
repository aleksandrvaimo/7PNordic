<?php
/**
 * Copyright © ...
 */

namespace Customer\Api\Data;

interface CustomerDataInterface
{
    public const ID ='id';
    public const USERNAME ='username';
    public const FIRSTNAME ='firstname';
    public const LASTNAME ='lastname';
    public const DOB ='dob';

    public function prepareCustomer(array $customerData = []): CustomerDataInterface;
}
