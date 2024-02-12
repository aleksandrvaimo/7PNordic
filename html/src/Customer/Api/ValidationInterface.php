<?php
/**
 * Copyright © ...
 */

namespace Customer\Api;

interface ValidationInterface
{
    public const PATTERN = '/[^a-zA-Z0-9-]+/';
    public const PATTERN_DATE = '/[^0-9-]+/';
    public const PATTERN_ID = '/[^0-9]+/';
    public const PATTERN_NAME = '/[^a-zA-Z]+/';
    public const MAX_LENGTH = 3;
    public const PARAM_USERNAME = 'username';
    public const PARAM_PASSWORD = 'password';
    public const PARAM_CRUD = 'crud';
    public const PARAM_DOB = 'dob';
    public const PARAM_ID = 'id';
    public const DATE_FORMAT = 'Y-m-d';
    public const PARAMS = [
        'id' => self::PATTERN_ID,
        'username' => self::PATTERN,
        'password' => self::PATTERN,
        'firstname' => self::PATTERN_NAME,
        'lastname' => self::PATTERN_NAME,
        'dob' => self::PATTERN_DATE
    ];

    public function isPostParamsExistsForCreateAction(): bool;
    public function isPostParamsExistsForUpdateAction(): bool;
    public function isIdParamValid(): bool;
    public function isUsernameParamValid(): bool;
    public function isUsernameAndIdValid(): bool;
    public function getParams(): array;
    public function isDataChanged(array $customerById): bool;
    public function sanitize(string $value): string;
}
