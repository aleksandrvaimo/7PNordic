<?php
/**
 * Copyright © ...
 */

namespace Customer\Model;

use Api\SessionInterface;
use Customer\Api\ValidationInterface;

class Validation implements ValidationInterface
{
    private array $params;

    public function __construct()
    {
        $this->setParams();
    }

    /**
     * Check if all needed params exist and are valid in POST variable
     * Used in Create action
     */
    public function isPostParamsExistsForCreateAction(): bool
    {
        /**
         * Remove ID from allowed params. Param is not needed on create action
         */
        $allowedParams = self::PARAMS;
        $params = $this->getParams();

        unset($allowedParams[self::PARAM_ID]);

        foreach ($allowedParams as $parameter => $pattern) {
            $this->changeValue($parameter);

            if (!isset($params[$parameter]) || !$this->isValid($parameter, $pattern)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if all needed params exist and are valid in POST variable
     * Used in Update action
     */
    public function isPostParamsExistsForUpdateAction(): bool
    {
        $params = $this->getParams();

        foreach ($params as $key => $value) {
            $this->changeValue($key);

            if (!isset(self::PARAMS[$key]) || $key == self::PARAM_PASSWORD && empty($params[$key])) {
                unset($params[$key]);
                continue;
            }

            if (!$this->isValid($key, self::PARAMS[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if id param is valid
     * Used in Delete action
     */
    public function isIdParamValid(): bool
    {
        return $this->isValid(self::PARAM_ID, self::PARAMS[self::PARAM_ID]);
    }

    /**
     * Check if id param is valid
     * Used in Search action
     */
    public function isUsernameParamValid(): bool
    {
        return $this->isValid(self::PARAM_USERNAME, self::PARAMS[self::PARAM_USERNAME]);
    }

    /**
     * Remove crud param from provided array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Set params from provided array
     */
    private function setParams(): void
    {
        if (empty($this->params)) {
            $this->params = $_POST;
        }

        $this->unsetParam(self::PARAM_CRUD);
    }

    /**
     * Unset param
     */
    private function unsetParam(string $field): void
    {
        if (isset($this->params[$field])) {
            unset($this->params[$field]);
        }
    }

    /**
     * Set param
     */
    private function setParam(string $field, string $value): void
    {
        $this->params[$field] = $value;
    }

    /**
     * Check if any record was changed baced on customer data
     * Used in Update action
     */
    public function isDataChanged(array $customerById): bool
    {
        $needToUpdate = false;
        $params = $this->getParams();
        /**
         * No needs to check password if wasn't changed
         */
        if (empty($params[self::PARAM_PASSWORD])) {
            $this->unsetParam(self::PARAM_PASSWORD);
        }

        foreach ($this->getParams() as $key => $value) {
            if (isset($customerById[$key]) && $customerById[$key] != $value) {
                $needToUpdate = true;
                break;
            }
        }

        return $needToUpdate;
    }

    /**
     * Both params username and id should exist
     */
    public function isUsernameAndIdValid(): bool
    {
        $params = $this->getParams();

        $id = $params[ValidationInterface::PARAM_ID] ?? '';
        $username = $params[ValidationInterface::PARAM_USERNAME] ?? '';

        return $id && $username;
    }

    public function sanitize(string $value): string
    {
        return trim(stripslashes(htmlspecialchars($value)));
    }

    private function isValid(string $field, string $pattern): bool
    {
        $params = $this->getParams();

        if (!$this->isLongValueEnough($field, $params[$field]) ||
            !$this->isFormatCorrect($pattern, $field, $params[$field])
        ) {
            return false;
        }

        return true;
    }

    private function isLongValueEnough(string $field, string $param): bool
    {
        if ($field != self::PARAM_ID && strlen($param) < SELF::MAX_LENGTH) {
            $_SESSION[SessionInterface::KEY_MSG] = $field . ' must be at least ' . SELF::MAX_LENGTH . ' characters in length';

            return false;
        }

        return true;
    }

    private function isFormatCorrect(string $pattern, string $field, string $param): bool
    {
        if (preg_match($pattern, $param)) {
            $_SESSION[SessionInterface::KEY_MSG] = $field . ' format is incorrect';

            return false;
        }

        return true;
    }

    /**
     * Sanitize values and prepare values
     */
    private function changeValue(string $field): void
    {
        $params = $this->getParams();
        $value = $this->sanitize($params[$field]);

        if ($field == self::PARAM_DOB) {
            $value = $this->changeDateFormat($field, $value);
        }

        $this->setParam($field, $value);
    }

    /**
     * Change date format in case needed
     */
    private function changeDateFormat(string $value, ?string $format = self::DATE_FORMAT): string
    {
        return date($format, strtotime($value));
    }
}
