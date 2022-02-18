<?php

require __DIR__ . '/vendor/autoload.php';

$queue = \App\Queue::getInstance();

for ($i = 0; $i < 5; $i++) {
    $queue->push(new \App\Messages\EmailMessage([
        'from' => 'tregubov622@gmail.com',
        'to' => 'tregubov.s@asteq.ru',
        'subject' => 'тестирование очереди на php',
        'body' => "Отправляю тебе число <b><i>$i</i></b>"
    ]), 'email');

    sleep(1);
}

