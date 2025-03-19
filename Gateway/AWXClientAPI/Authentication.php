<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI;

use Airwallex\CommonLibrary\Cache\CacheManager;
use Airwallex\CommonLibrary\Configuration\Init;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use Composer\InstalledVersions;

class Authentication extends AbstractApi
{
    protected function getHeaders(): array
    {
        return [
            'x-client-id' => Init::getInstance()->get('client_id'),
            'x-api-key' => Init::getInstance()->get('api_key'),
        ];
    }

    protected function getUri(): string
    {
        return 'authentication/login';
    }

    protected function parseResponse(ResponseInterface $response)
    {
        return $this->parseJson($response);
    }
}