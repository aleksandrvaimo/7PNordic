<?php
/**
 * Copyright © ...
 */

namespace Customer\Model\Resource;

use Connection\MyDB;

class Collection extends MyDB
{
    public function getCollection(?string $sort = null): array
    {
        $sql = 'SELECT * FROM customer';
        if ($sort) {
            $sql .= ' ORDER BY ' . $sort . ' ASC';
        }

        $result = $this->getDbRequest($sql);

        return $result && $result->num_rows
            ? $result->fetch_all(MYSQLI_ASSOC)
            : [];
    }

    public function getCollectionByUsername(string $username, ?string $sort = null): array
    {
        $sql = "SELECT * FROM customer WHERE username like '%" . $username . "%'";
        if ($sort) {
            $sql .= ' ORDER BY ' . $sort . ' ASC';
        }
        $result = $this->getDbRequest($sql);

        return $result && $result->num_rows
            ? $result->fetch_all(MYSQLI_ASSOC)
            : [];
    }
}
