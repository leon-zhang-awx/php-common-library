<?php
namespace Airwallex\CommonLibrary\Cache;

use RuntimeException;

class CacheManager
{
    private static $cache = null;

    public static function setInstance(CacheInterface $cache): void {
        self::$cache = $cache;
    }

    public static function getInstance(): CacheInterface {
        if (self::$cache === null) {
            throw new RuntimeException('Cache not initialized');
        }
        return self::$cache;
    }
}