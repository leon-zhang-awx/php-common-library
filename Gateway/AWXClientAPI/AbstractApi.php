<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI;

use Airwallex\CommonLibrary\Cache\CacheManager;
use Airwallex\CommonLibrary\Configuration\Init;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Composer\InstalledVersions;

abstract class AbstractApi
{
    protected const TIMEOUT = 30;
    protected const X_API_VERSION = '2024-06-30';
    protected $params = [];

    /**
     * Sends API request and returns parsed response.
     *
     * @return mixed Parsed response
     * @throws GuzzleException
     * @throws Exception
     */
    public function send()
    {
        $client = new Client([
            'base_uri' => $this->getBaseUrl(),
            'timeout' => self::TIMEOUT,
        ]);

        $method = $this->getMethod();
        $options = [
            'headers' => array_merge($this->getHeaders(), [
                'Content-Type' => 'application/json',
                'region' => 'string',
                'x-api-version' => self::X_API_VERSION
            ]),
            'http_errors' => false
        ];

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
     * Initializes necessary parameters for POST request.
     *
     * @return void
     */
    protected function initializePostParams(): void
    {
        $this->params['request_id'] = $this->generateRequestId();
        $this->params['referrer_data'] = $this->getReferrerData();
        $this->params['metadata'] = $this->getMetadata();
    }

    /**
     * Generates a unique request ID.
     *
     * @return string
     */
    private function generateRequestId(): string
    {
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
    }

    /**
     * Sets multiple request parameters.
     *
     * @param array $params
     * @return self
     */
    protected function setParams(array $params): self
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    /**
     * Sets a specific request parameter.
     *
     * @param string $name Parameter name
     * @param string $value Parameter value
     * @return self
     */
    protected function setParam(string $name, string $value): self
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * Removes a specific request parameter.
     *
     * @param string $name Parameter name
     * @return self
     */
    protected function unsetParam(string $name): self
    {
        unset($this->params[$name]);
        return $this;
    }

    /**
     * Returns metadata information.
     *
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
     * Returns API base URL depending on environment.
     *
     * @return string
     */
    private function getBaseUrl(): string
    {
        return Init::getInstance()->get('env') === 'demo'
            ? 'https://pci-api-demo.airwallex.com/api/v1/'
            : 'https://pci-api.airwallex.com/api/v1/';
    }

    /**
     * Returns request method type (default is GET).
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'POST';
    }

    /**
     * Retrieves referrer data.
     *
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
     * Returns the request URI.
     *
     * @return string
     */
    abstract protected function getUri(): string;

    /**
     * Parses the API response.
     *
     * @param ResponseInterface $response
     * @return mixed Parsed response
     */
    abstract protected function parseResponse(ResponseInterface $response);

    /**
     * Returns authorization headers.
     *
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
     * Retrieves or generates an authentication token.
     *
     * @return string
     * @throws GuzzleException
     */
    protected function getToken(): string
    {
        $cache = CacheManager::getInstance();
        $token = $cache->get('airwallex_token');

        if (!$token) {
            $token = (new Authentication())->send()->token;
            $cache->set('airwallex_token', $token, 60 * 30);
        }

        return $token;
    }

    /**
     * Parses JSON response into an object.
     *
     * @param ResponseInterface $response
     * @return object Parsed JSON object
     */
    protected function parseJson(ResponseInterface $response): object
    {
        return json_decode((string)$response->getBody(), false);
    }
}