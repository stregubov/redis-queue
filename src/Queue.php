<?php

namespace App;

use App\Messages\AbstractMessage;

class Queue
{
    private ?\Redis $connection;

    private static ?Queue $instance = null;

    public static function getInstance(): self
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __construct()
    {
        $this->connection = Connection::getInstance()->getRedisClient();
    }

    public function push(AbstractMessage $data, string $queueName = 'default'): false|int
    {
        return $this->connection->lPush($queueName, serialize($data));
    }

    public function pop(string $queueName = 'default'): AbstractMessage|false
    {
        return unserialize($this->connection->lPop($queueName));
    }
}