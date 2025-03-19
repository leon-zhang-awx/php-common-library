<?php
namespace Airwallex\CommonLibrary\Cache;

interface CacheInterface
{
    public function get(string $key);

    public function set(string $key, $value, int $ttl = 0): bool;
}