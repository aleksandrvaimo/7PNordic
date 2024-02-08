<?php
/**
 * Copyright © ...
 */

namespace Customer\Model;

use Customer\Model\CustomerData;

class CustomerDataFactory
{
    public static function create()
    {
        return new CustomerData();
    }
}
