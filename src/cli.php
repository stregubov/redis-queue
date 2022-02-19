<?php

use App\Handlers\AbstractHandler;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__.'/../.env');

$queue = \App\Queue::getInstance();

$lastMessage = null;
while (true) {
    $lastMessage = $queue->pop('email');

    // Если в очереди ничего не было, то будем ждать 5 секунд, а потом повторим
    if (!$lastMessage) {
        sleep(5);
        continue;
    }

    $handler = $lastMessage->getHandlerName();

    if (!class_exists($handler)) {
        throw new Exception('Отсутствует класс для обработки сообщения '. get_class($lastMessage));
    }

    $r = new \ReflectionClass($handler);
    /** @var AbstractHandler $handlerInstance */
    $handlerInstance = $r->newInstanceWithoutConstructor();
    $handlingResult = $handlerInstance::handle($lastMessage);

    // если не вышло количество попыток, то добавляем обратно в начало очереди (RR алгоритм)
    if (!$handlingResult && $lastMessage->decrementAttempts() > 0) {
        $queue->push($lastMessage, 'email');
    }
}


