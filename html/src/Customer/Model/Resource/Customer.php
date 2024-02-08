<?php
/**
 * Copyright © ...
 */

namespace Customer\Model\Resource;

use Connection\MyDB;

class Customer extends MyDB
{
    private array $userById = [];
    private array $userByUsername = [];

    public function getCustomerById(string $id): false|array
    {
        if (isset($this->userById[$id])) {
            return $this->userById[$id];
        }

        $sql = 'SELECT * FROM customer WHERE id = ?';
        $result = $this->getDbRequest($sql, [[$id]]);

        $this->userById[$id] = $result && $result->num_rows
            ? $result->fetch_assoc()
            : false;

        return $this->userById[$id];
    }

    public function getCustomerByUsername(string $username): false|array
    {
        if (isset($this->userByUsername[$username])) {
            return $this->userByUsername[$username];
        }

        $sql = 'SELECT * FROM customer WHERE username = ?';
        $result = $this->getDbRequest($sql, [[$username]]);

        $this->userByUsername[$username] = $result && $result->num_rows
            ? $result->fetch_assoc()
            : false;

        return $this->userByUsername[$username];
    }

    public function getCollection(): array
    {
        $sql = 'SELECT * FROM customer';
        $result = $this->getDbRequest($sql);

        return $result && $result->num_rows
            ? $result->fetch_all(MYSQLI_ASSOC)
            : [];
    }

    public function create(array $customer): void
    {
        if (!$this->getCustomerByUsername($customer['username'])) {
            $sql = 'INSERT INTO `customer` (`username`, `firstname`, `lastname`, `dob`, `password`) VALUES (?,?,?,?,?);';

            $options = ['cost' => self::BCRYPT_COST];
            $customer['password'] = password_hash($customer['password'], PASSWORD_BCRYPT, $options);

            $this->getDbRequest($sql, [$customer]);
        }
    }

    public function update(array $customer): void
    {
        $realCustomer = $this->getCustomerById($customer['id']);

        if ($realCustomer) {
            $sql = 'UPDATE `customer` SET `id` = ?,  `username` = ?, `firstname` = ?, `lastname` = ?, `dob` = ?, `password` = ? WHERE id = ?;';

            if (isset($customer['password'])) {
                $options = ['cost' => self::BCRYPT_COST];
                $customer['password'] = password_hash($customer['password'], PASSWORD_BCRYPT, $options);
            }

            $customer = array_merge($realCustomer, $customer);
            $customer['id_last'] = $customer['id'];

            $this->getDbRequest($sql, [$customer]);
        }
    }

    public function delete(array $customer): void
    {
        $realCustomer = $this->getCustomerById($customer['id']);
        if ($realCustomer) {
            $sql = 'DELETE FROM `customer` WHERE id= ?;';

            $this->getDbRequest($sql, [$customer['id']]);
        }
    }
}
