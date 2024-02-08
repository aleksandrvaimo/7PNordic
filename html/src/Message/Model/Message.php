<?php
/**
 * Copyright © ...
 */

namespace Message\Model;

use Api\SessionInterface;
use Message\Api\MessageInterface;

class Message implements MessageInterface
{
    private ?bool $isMessageExists = null;

    public function isMessageExists(): bool
    {
        if ($this->isMessageExists === null) {
            $this->isMessageExists = isset($_SESSION[SessionInterface::KEY_MSG]) &&
                !empty($_SESSION[SessionInterface::KEY_MSG]);
        }

        return $this->isMessageExists;
    }

    public function getMessage(): string
    {
        $message = '';

        if ($this->isMessageExists()) {
            $message = $_SESSION[SessionInterface::KEY_MSG];
            unset($_SESSION[SessionInterface::KEY_MSG]);
        }

        return $message;
    }

    public function log(string $message): void
    {
        error_log($message . "\n", 3, $_SERVER['PWD'] . self::filePath);
    }
}
