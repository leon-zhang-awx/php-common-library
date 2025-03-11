<?php

use Airwallex\CommonLibrary\Cache\CacheManager;
use Airwallex\CommonLibrary\Configuration\Init;
use Airwallex\CommonLibrary\tests\mock\Cache;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Init::getInstance([
    'env' => 'demo',
    'client_id' => $_ENV['CLIENT_ID'],
    'api_key' => $_ENV['API_KEY'],
]);
CacheManager::setInstance(new Cache());
