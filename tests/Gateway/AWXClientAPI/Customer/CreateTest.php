<?php declare(strict_types=1);

namespace Airwallex\CommonLibrary\tests\Gateway\AWXClientAPI\Customer;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer\Create;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

final class CreateTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testCustomerCreate(): void
    {
        $response = (new Create())->setCustomerId()->send();
        $this->assertStringContainsStringIgnoringCase('merchant_customer_id', $response);
        $this->assertStringContainsStringIgnoringCase('client_secret', $response);
    }
}