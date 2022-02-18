<?php

namespace App\Handlers;

use App\Messages\MessageInterface;

abstract class AbstractHandler
{
    public static string $queueName = '';

    public abstract static function handle(MessageInterface $message): bool;
}