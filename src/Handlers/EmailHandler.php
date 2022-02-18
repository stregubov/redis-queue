<?php

namespace App\Handlers;

use App\Messages\MessageInterface;
use App\Services\EMailService;

class EmailHandler extends AbstractHandler
{
    public static string $queueName = 'email';

    /**
     * @param MessageInterface $message
     * @return bool
     */
    public static function handle(MessageInterface $message): bool
    {
        $mailService = EMailService::getInstance();
        return $mailService->sendMail($message);
    }
}