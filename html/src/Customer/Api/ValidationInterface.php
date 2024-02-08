<?php
/**
 * Copyright © ...
 */

namespace Customer\Api;

interface ValidationInterface
{
    const PATTERN = '/[^a-zA-Z0-9-]+/';
    const PATTERN_DATE = '/[^0-9-]+/';
    const PATTERN_ID = '/[^0-9]+/';
    const PATTERN_NAME = '/[^a-zA-Z]+/';
    CONST MAX_LENGTH = 3;
    const PARAM_USERNAME = 'username';
    const PARAM_PASSWORD = 'password';
    const PARAM_CRUD = 'crud';
    const PARAM_DOB = 'dob';
    const PARAM_ID = 'id';
    const PARAMS = [
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
