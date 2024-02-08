<?php
/**
 * Copyright © ...
 */

namespace Customer\Api;

use Customer\Api\Data\CustomerDataInterface;

interface CustomerInterface
{
    public const MSG_CUSTOMER = 'Customer does not exist';

    public function getCustomerByUsername(string $username = ''): CustomerDataInterface;
}
