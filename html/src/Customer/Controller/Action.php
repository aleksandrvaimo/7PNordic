<?php
/**
 * Copyright © ...
 */

namespace Customer\Controller;

use Api\SessionInterface;
use Customer\Model\Resource\Customer;
use Customer\Api\ValidationInterface;
use Message\Api\MessageInterface;

abstract class Action
{
    public const HTTP_X_REQUESTED_WITH = 'HTTP_X_REQUESTED_WITH';
    public const XML_HTTP_REQUEST = 'xmlhttprequest';

    protected Customer $request;
    protected ValidationInterface $validation;
    protected MessageInterface $message;

    public function __construct(Customer $request, ValidationInterface $validation, MessageInterface $message)
    {
        $this->request = $request;
        $this->validation = $validation;
        $this->message = $message;
    }

    public function execute(): array
    {
        return [];
    }

    protected function response($status, $msg): array
    {
        $response = [
            'status' => $status,
            'msg' => $_SESSION[SessionInterface::KEY_MSG] ?? $msg
        ];

        $this->removeSessionMsg($status);

        return $response;
    }

    protected function process(): array
    {
        return [];
    }

    protected function removeSessionMsg(string $status): void
    {
        if ($status != 'success' && isset($_SESSION[SessionInterface::KEY_MSG])) {
            unset($_SESSION[SessionInterface::KEY_MSG]);
        }
    }
}
