<?php
/**
 * Copyright © ...
 */

namespace Customer\Model;

use Customer\Api\Data\CustomerDataInterface;

class CustomerData implements CustomerDataInterface
{
    private ?int $id;
    private ?string $username;
    private ?string $firstname;
    private ?string $lastname;
    private ?string $dob;

    public function prepareCustomer(array $customerData = []): CustomerDataInterface
    {
        $this->setId($customerData[self::ID] ?? '');
        $this->setUsername($customerData[self::USERNAME] ?? '');
        $this->setFirstname($customerData[self::FIRSTNAME] ?? '');
        $this->setLastname($customerData[self::LASTNAME] ?? '');
        $this->setDob($customerData[self::DOB] ?? '');

        return $this;
    }

    public function setId(?int $id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername(?string $username)
    {
        $this->username = $username;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setFirstname(?string $firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setLastname(?string $lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setDob(?string $dob)
    {
        $this->dob = $dob;
    }

    public function getDob(): ?string
    {
        return $this->dob;
    }
}
