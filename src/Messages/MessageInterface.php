<?php

namespace App\Messages;

interface MessageInterface
{
    public function getHandlerName(): string;
    public function getData(): mixed;
}