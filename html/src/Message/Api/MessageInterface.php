<?php
/**
 * Copyright © ...
 */

namespace Message\Api;

interface MessageInterface
{
    public const filePath = '/log/system.log';

    public function isMessageExists(): bool;
    public function getMessage(): string;
    public function log(string $message): void;
}
