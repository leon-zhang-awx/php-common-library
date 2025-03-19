<?php declare(strict_types=1);

namespace Airwallex\CommonLibrary\tests\Gateway\PluginService\Log;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer\Create;
use Airwallex\CommonLibrary\Gateway\PluginService\Log\Log;
use PHPUnit\Framework\TestCase;

final class LogTest extends TestCase
{
    public function testCustomerCreate(): void
    {
        Log::debug('Customer Create', 'xxx', 'vvv');
    }
}