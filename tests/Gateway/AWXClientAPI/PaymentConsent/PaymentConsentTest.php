<?php declare(strict_types=1);

namespace Airwallex\CommonLibrary\tests\Gateway\AWXClientAPI\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer\Create;
use Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent\Index;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

final class PaymentConsentTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testPaymentConsent()
    {
        $response = (new Create())->setCustomerId()->send();
        $arr = json_decode($response, true);
        $this->assertArrayHasKey('id', $arr);
        $customerId = $arr['id'];
        $response = (new Index())->setCustomerId($customerId)->send();
        $all = json_decode($response, true);
        $this->assertEmpty($all['items']);
    }
}