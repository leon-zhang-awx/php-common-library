<?php

namespace Airwallex\CommonLibrary\tests\mock;
use Airwallex;

class Cache implements Airwallex\CommonLibrary\Cache\CacheInterface
{
    public $cache = [];

    public function get(string $key)
    {
        return $this->cache[$key] ?? null;
    }

    public function set(string $key, $value, int $ttl = 0): bool
    {
        $this->cache[$key] = $value;
        return true;
    }
}