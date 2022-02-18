<?php

namespace App\Messages;

abstract class AbstractMessage implements MessageInterface
{
    private int $maxAttempts = 3;
    private int $availableAttempts = 3;

    /**
     * @return int
     */
    public function getMaxAttempts(): int
    {
        return $this->maxAttempts;
    }

    /**
     * @return int
     */
    public function getAvailableAttempts(): int
    {
        return $this->availableAttempts;
    }

    public function decrementAttempts(): int
    {
        return --$this->availableAttempts;
    }

}