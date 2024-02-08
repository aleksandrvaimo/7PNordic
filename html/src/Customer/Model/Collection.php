<?php
/**
 * Copyright © ...
 */

namespace Customer\Model;

use Customer\Api\CollectionInterface;
use Customer\Api\ValidationInterface;
use Customer\Model\Resource\Collection as CustomerCollection;
use Customer\Model\CustomerDataFactory;

class Collection implements CollectionInterface
{
    private CustomerCollection $request;
    private ValidationInterface $validation;
    public function __construct(CustomerCollection $request, ValidationInterface $validation)
    {
        $this->request = $request;
        $this->validation = $validation;
    }

    /**
     * Get customer collection
     */
    public function getCollection(): array
    {
        $username = $_GET[self::SEARCH] ?? null;
        $sort = $this->getSortValue();

        if (isset($username)) {
            $username = $this->validation->sanitize($username);
            $collection = $this->getCollectionByUsername($username, $sort);
        } else {
            $collection = $this->request->getCollection($sort);
        }

        return $this->prepareCollection($collection);
    }

    /**
     * Get customer collection
     */
    private function getCollectionByUsername(string $username, string $sort): array
    {
        $username = $this->validation->sanitize($username);

        return $this->request->getCollectionByUsername($username, $sort);
    }

    private function getSortValue(): string
    {
        $sort = $_GET[self::SORT] ?? null;
        $sort = $sort ? strtolower($sort) : null;

        if ($sort && $this->isSortAllowed($sort)) {
            return $this->validation->sanitize($sort);
        }

        return '';
    }

    private function isSortAllowed(string $sort): bool
    {
        return in_array($sort, self::ALLOWED_FIELDS_FOR_SORTING);
    }

    private function prepareCollection($collection): array
    {
        if (empty($collection)) {
            return [];
        } else {
            /**
             * Prepare collection
             */
            foreach ($collection as $key => $customerData) {
                $customer = CustomerDataFactory::create();
                $collection[$key] = $customer->prepareCustomer($customerData);
            }
        }

        return $collection;
    }
}
