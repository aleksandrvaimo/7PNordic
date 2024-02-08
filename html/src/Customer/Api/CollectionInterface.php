<?php
/**
 * Copyright © ...
 */

namespace Customer\Api;

use Customer\Api\Data\CustomerDataInterface;

interface CollectionInterface
{
    public const MSG_COLLECTION = 'Collection is empty';
    public const SORT = 'sort';
    public const SEARCH = 'q';
    public const ALLOWED_FIELDS_FOR_SORTING = ['username', 'firstname', 'lastname', 'date'];

    public function getCollection(): array;
}
