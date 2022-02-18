<?php

namespace App;

class Connection
{
    private static ?Connection $instance = null;

    private ?\Redis $redisClient = null;

    public static function getInstance(): self
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function getRedisClient(): ?\Redis
    {
        return $this->redisClient;
    }

    /**
     * @throws \Exception
     */
    private function __construct()
    {
        $this->redisClient = new \Redis();

        //$this->redisClient->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_JSON);

        $connectionResult = $this->redisClient->connect('127.0.0.1', 6379, 2.5);
        if (!$connectionResult) {
            throw new \Exception($this->redisClient->getLastError());
        }
    }

    public function __sleep()
    {
    }

    public function __wakeup()
    {
    }
}