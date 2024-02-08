<?php
/**
 * Copyright © ...
 */

namespace Customer\Model;

use Customer\Api\Data\CustomerDataInterface;
use Customer\Model\Resource\Customer as ResourceCustomer;
use Customer\Api\CustomerInterface;

class Customer implements CustomerInterface
{
    private ResourceCustomer $request;
    private CustomerData $customerData;

    public function __construct(ResourceCustomer $request, CustomerDataInterface $customerData)
    {
        $this->request = $request;
        $this->customerData = $customerData;
    }

    public function getCustomerByUsername(string $username = ''): CustomerDataInterface
    {
        $customer = $this->request->getCustomerByUsername($username);

        if (!$customer) {
            $_SESSION[SessionInterface::KEY_MSG]  = self::MSG_CUSTOMER;
        }

        return $this->customerData->prepareCustomer($customer ? $customer : []);
    }
}
