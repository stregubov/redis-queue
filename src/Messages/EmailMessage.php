<?php

namespace App\Messages;

use App\Handlers\AbstractHandler;
use App\Handlers\EmailHandler;

class EmailMessage extends AbstractMessage
{
    public mixed $data = null;
    private string $handler;

    public function getHandlerName(): string
    {
        return $this->handler;
    }

    public function getMaxAttempts(): int
    {
        return 1;
    }

    public function getAttempts(): int
    {
        return 1;
    }

    public function __construct($data)
    {
        $this->data = $data;
        $this->handler = EmailHandler::class;
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}