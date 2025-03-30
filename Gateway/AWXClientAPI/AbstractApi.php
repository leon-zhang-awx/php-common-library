<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI;

use Airwallex\CommonLibrary\Cache\CacheManager;
use Airwallex\CommonLibrary\Configuration\Init;
use Airwallex\CommonLibrary\Struct\AccessToken;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Composer\InstalledVersions;

abstract class AbstractApi
{
    /**
     * @var int
     */
    const TIMEOUT = 30;

    /**
     * @var string
     */
    const DEMO_BASE_URL = 'https://pci-api-demo.airwallex.com/api/v1/';

    /**
     * @var string
     */
    const PRODUCTION_BASE_URL = 'https://pci-api.airwallex.com/api/v1/';

    /**
     * @var string
     */
    const X_API_VERSION = '2024-06-30';

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @return mixed
     * @throws GuzzleException
     * @throws Exception
     */
    public function send()
    {
        $client = new Client([
            'base_uri' => $this->getBaseUrl(),
            'timeout' => self::TIMEOUT,
        ]);

        $options = [
            'headers' => array_merge($this->getHeaders(), [
                'Content-Type' => 'application/json',
                'x-api-version' => self::X_API_VERSION
            ]),
            'http_errors' => false
        ];

        $method = $this->getMethod();
        if ($method === 'POST') {
            $this->initializePostParams();
            $options['json'] = $this->params;
        } elseif ($method === 'GET') {
            $options['query'] = $this->params;
        }

        $response = $client->request($method, $this->getUri(), $options);
        return $this->parseResponse($response);
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function initializePostParams()
    {
        $this->params['request_id'] = $this->generateRequestId();
        $this->params['referrer_data'] = $this->getReferrerData();
        $this->params['metadata'] = $this->getMetadata();
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function generateRequestId(): string
    {
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
    }

    /**
     * @param array $params
     * @return self
     */
    protected function setParams(array $params): self
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return self
     */
    protected function setParam(string $name, string $value): self
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @return self
     */
    protected function unsetParam(string $name): self
    {
        unset($this->params[$name]);
        return $this;
    }

    /**
     * @return array
     */
    protected function getMetadata(): array
    {
        return [
            'php_version' => phpversion(),
            'platform_version' => Init::getInstance()->get('platform_version'),
            'common_library_version' => InstalledVersions::getPrettyVersion(InstalledVersions::getRootPackage()['name']),
            'host' => $_SERVER['HTTP_HOST'] ?? '',
        ];
    }

    /**
     * @return string
     */
    protected function getBaseUrl(): string
    {
        return Init::getInstance()->get('env') === 'demo' ? self::DEMO_BASE_URL : self::PRODUCTION_BASE_URL;
    }

    /**
     * @return string
     */
    protected function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @return array
     */
    private function getReferrerData(): array
    {
        return [
            'type' => Init::getInstance()->get('plugin_type'),
            'version' => Init::getInstance()->get('plugin_version'),
        ];
    }

    /**
     * @return string
     */
    abstract protected function getUri(): string;

    /**
     * @param Response $response
     * @return mixed
     */
    abstract protected function parseResponse(Response $response);

    /**
     * @return array
     * @throws GuzzleException
     */
    protected function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ];
    }

    /**
     * @return string
     * @throws GuzzleException
     */
    protected function getToken(): string
    {
        $cache = CacheManager::getInstance();
        $token = $cache->get('airwallex_token');

        if (!$token) {
            /** @var AccessToken $accessToken */
            $accessToken = (new Authentication())->send();
            $token = $accessToken->getToken();
            $cache->set('airwallex_token', $token, 60 * 30);
        }

        return $token;
    }
}
