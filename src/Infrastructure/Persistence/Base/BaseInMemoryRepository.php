<?php

namespace App\Infrastructure\Persistence\Base;

use Redis;

abstract class BaseInMemoryRepository
{
    protected Redis $redis;

    public function __construct(Redis $redis) {
        $this->redis = $redis;
    }

    protected function getRedis(): Redis {
        return $this->redis;
    }

}