<?php
namespace Airwallex\CommonLibrary\Configuration;

class Init {
    private static $instance = null;
    protected $config = [];

    private function __construct(array $config = []) {
        $this->config = $config;
    }

    private function __clone() {}

    public static function getInstance(array $config = []) {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function get($key, $default = null) {
        return $this->config[$key] ?? $default;
    }
}