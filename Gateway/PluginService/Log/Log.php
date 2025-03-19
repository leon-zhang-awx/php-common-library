<?php

namespace Airwallex\CommonLibrary\Gateway\PluginService\Log;

use Airwallex\CommonLibrary\Configuration\Init;
use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;

class Log extends AbstractApi
{
    private static $sessionId;
    private static $instance;

    protected function getHeaders(): array
    {
        return [
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
        ];
    }

    protected function getUri(): string
    {
        return 'papluginlogs/logs';
    }

    protected function decodeJWT($token)
    {
        if (!strstr($token, '.')) return 'decode failed';
        $str = base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))) ?? '';
        if (!$str) return 'decode failed';
        $arr = json_decode($str, true);
        return $arr['account_id'] ?? 'decode failed';
    }

    protected function getAccountId()
    {
        return $this->decodeJWT($this->getToken());
    }

    protected static function getSessionId()
    {
        if (!isset(self::$sessionId)) {
            self::$sessionId = uniqid('php_common_library_', true);
        }

        return self::$sessionId;
    }

    protected function getClientPlatform()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        if (strpos($userAgent, 'Linux') !== false) {
            return 'linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            return 'android';
        } elseif (strpos($userAgent, 'Windows') !== false) {
            return 'windows';
        } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
            return 'ios';
        } elseif (strpos($userAgent, 'Macintosh') !== false || strpos($userAgent, 'Mac OS X') !== false) {
            return 'macos';
        } else {
            return 'other';
        }
    }

    protected function initializePostParams(): void
    {
        $this->params['commonData'] = [
            'accountId' => $this->getAccountId(),
            'appName' => 'pa_plugin',
            'source' => Init::getInstance()->get('plugin_type') ?: 'php_common_library',
            'deviceId' => 'unknown',
            'sessionId' => self::getSessionId(),
            'appVersion' => Init::getInstance()->get('plugin_version'),
            'platform' => $this->getClientPlatform(),
            'env' => Init::getInstance()->get('env') === 'demo' ? 'demo' : 'prod',
        ];
    }

    public static function getInstance()
    {
         if (self::$instance === null) {
             self::$instance = new Log();
         }
         return self::$instance;
    }

    public static function debug($eventName, $message, $type)
    {
        $instance = self::getInstance();
        $instance->initializePostParams();
            $instance->setParams([
                'data' => [
                    [
                        'severity' => 'debug',
                        'eventName' => $eventName,
                        'message' => $message,
                        'type' => $type,
                        'trace' => debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ),
                    ]
                ]
            ]);
        $resp = $instance->send();
        var_dump($resp);
    }

    protected function parseResponse(ResponseInterface $response)
    {
        return $this->parseJson($response);
    }
}