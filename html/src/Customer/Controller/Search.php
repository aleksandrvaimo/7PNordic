<?php
/**
 * Copyright © ...
 */

namespace Customer\Controller;

use Customer\Api\ValidationInterface;

/**
 * Not really needed but can be used for some future purposes
 */
class Search
{
    private ValidationInterface $validation;

    public function __construct(ValidationInterface $validation)
    {
        $this->validation = $validation;
    }
    public function execute(): string
    {
        if (!$this->validation->isUsernameParamValid()) {
            return '';
        }

        $params = $this->validation->getParams();

        return $params[ValidationInterface::PARAM_USERNAME];
    }
}
