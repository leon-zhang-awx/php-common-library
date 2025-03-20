<?php

namespace Airwallex\CommonLibrary\Gateway\PluginService\Log;

use Airwallex\CommonLibrary\Configuration\Init;
use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Log
 * Handles logging functionality for Airwallex Plugin Service.
 */
class Log extends AbstractApi
{
    private static $sessionId = null;
    private static $instance = null;

    /**
     * Get the base API URL based on the environment.
     *
     * @return string
     */
    protected function getBaseUrl()
    {
        return Init::getInstance()->get('env') === 'demo'
            ? 'https://api-demo.airwallex.com/'
            : 'https://api.airwallex.com/';
    }

    /**
     * Returns custom headers for requests.
     *
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
        ];
    }

    /**
     * Returns the API endpoint URI.
     *
     * @return string
     */
    protected function getUri()
    {
        return 'papluginlogs/logs';
    }

    /**
     * Decodes a JWT token and extracts `account_id`, if available.
     *
     * @param string $token
     * @return string
     */
    protected function decodeJWT($token)
    {
        $parts = explode('.', $token);
        if (count($parts) < 2) {
            return 'decode failed';
        }

        $decoded = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);

        return $decoded['account_id'] ?? 'decode failed';
    }

    /**
     * Retrieves the Account ID from the token.
     *
     * @return string
     * @throws GuzzleException
     */
    protected function getAccountId()
    {
        return $this->decodeJWT($this->getToken());
    }

    /**
     * Generates and returns a unique Session ID.
     *
     * @return string
     */
    protected static function getSessionId()
    {
        if (!isset(self::$sessionId)) {
            self::$sessionId = uniqid('', true);
        }

        return self::$sessionId;
    }

    /**
     * Determines the client’s platform using the User-Agent header.
     *
     * @return string
     */
    protected function getClientPlatform()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $platforms = [
            'linux'    => 'Linux',
            'android'  => 'Android',
            'windows'  => 'Windows',
            'ios'      => ['iPhone', 'iPad'],
            'macos'    => ['Macintosh', 'Mac OS X'],
            'other'    => '',
        ];

        foreach ($platforms as $key => $values) {
            foreach ((array)$values as $value) {
                if (strpos($userAgent, $value) !== false) {
                    return $key;
                }
            }
        }

        return 'other';
    }

    /**
     * Initializes common parameters for logging requests.
     *
     * @return void
     * @throws GuzzleException
     */
    protected function initializePostParams()
    {
        $this->setParams([
            'commonData' => [
                'accountId'  => $this->getAccountId(),
                'appName'    => 'pa_plugin',
                'source'     => Init::getInstance()->get('plugin_type') ?: 'php_common_library',
                'deviceId'   => 'unknown',
                'sessionId'  => self::getSessionId(),
                'appVersion' => Init::getInstance()->get('plugin_version'),
                'platform'   => $this->getClientPlatform(),
                'env'        => Init::getInstance()->get('env') === 'demo' ? 'demo' : 'prod',
            ]
        ]);
    }

    /**
     * Returns the singleton instance of the Log class.
     *
     * @return self
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Log();
        }
        return self::$instance;
    }

    /**
     * Logs an informational event.
     *
     * @param string $eventName
     * @param string $message
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public static function info($message, $eventName = "")
    {
        return self::log('info', $eventName, $message);
    }

    /**
     * Logs an error event.
     *
     * @param string $eventName
     * @param string $message
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public static function error($message, $eventName = "")
    {
        return self::log('error', $eventName, $message);
    }

    /**
     * Generic log function to log messages.
     *
     * @param string $severity
     * @param string $eventName
     * @param string $message
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public static function log($severity, $eventName, $message)
    {
        $instance = self::getInstance();
        $instance->setParams([
            'data' => [
                [
                    'severity'  => $severity,
                    'eventName' => $eventName,
                    'message'   => $message,
                    'trace'     => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS),
                    'metadata'  => $instance->getMetadata(),
                ]
            ]
        ]);

        return $instance->send();
    }

    /**
     * Parses the API response.
     *
     * @param ResponseInterface $response
     * @return string
     */
    protected function parseResponse($response)
    {
        return (string) $response->getBody();
    }
}
