<?php
/**
 * Copyright © ...
 */

namespace Connection;

use Message\Api\MessageInterface;
use mysqli;
use mysqli_result;

class MyDB
{
    private const USERNAME = 'user';
    private const PASSWORD = 'test';
    private const DB = 'db';
    private const LOCALHOST = 'mysql';
    public const BCRYPT_COST = 14;
    private ?mysqli $connection = null;
    private MessageInterface $message;

    function __construct(MessageInterface $message)
    {
        $this->message = $message;
        $this->initialize();
    }

    /**
     * @return mysqli|void
     */
    private function getDbConnection(): ?mysqli
    {
        if ($this->connection === null) {
            try {
                $this->connection = new mysqli(
                    self::LOCALHOST,
                    self::USERNAME,
                    self::PASSWORD,
                    self::DB
                );
            } catch (\Exception $ex) {
                $this->message->log('Connection failed: ' . $ex->getMessage());
            }
        }

        return $this->connection;
    }

    /**
     * @param string $sql
     * @param array $params
     *
     * @return bool|array
     */
    protected function getDbRequest(string $sql, array $params = []): bool|mysqli_result
    {
        $result = false;

        try {
            $mysql = $this->getDbConnection();
            if (!$mysql) {
                return $result;
            }
            
            $statement = $mysql->prepare($sql);

            foreach ($params as $values) {
                $newValue = $this->validateValue($mysql, $values);
                $types = str_repeat('s', count($newValue));
                $statement->bind_param($types, ...$newValue);
            }

            $statement->execute();
            $result = $statement->get_result();

            $statement->close();
        } catch (\Exception $ex) {
            $this->message->log($ex->getMessage());
        } catch (\mysqli_sql_exception $ex) {
            $this->message->log($ex->getMessage());
        }

        return $result;
    }

    /**
     * Validate value before usage
     *
     * @param mysqli $mysql
     * @param string|array $values
     *
     * @return array
     */
    private function validateValue(mysqli $mysql, string|array $values): array
    {
        $result = [];

        if (is_array($values)) {
            foreach ($values as $value) {
                $result[] = $mysql->real_escape_string($value);
            }
        } else {
            $result[] = $mysql->real_escape_string($values);
        }

        return $result;
    }

    /**
     * Create customer table
     *
     * @return void
     */
    private function initialize(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `customer` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
            `username` varchar(255) UNIQUE DEFAULT NULL COMMENT 'Username',
            `firstname` varchar(255) DEFAULT NULL COMMENT 'First Name',
            `lastname` varchar(255) DEFAULT NULL COMMENT 'Last Name',
            `dob` date DEFAULT NULL COMMENT 'Date of Birth',
            `password` varchar(128) DEFAULT NULL COMMENT 'Password',
            PRIMARY KEY (`id`)
        )";

        $connection = $this->getDbConnection();

        try {
            if ($connection) {
                $connection->query($sql);
            }
        } catch (\Exception $ex) {
            $this->message->log('Connection failed: ' . $ex->getMessage());
        }
    }
}
