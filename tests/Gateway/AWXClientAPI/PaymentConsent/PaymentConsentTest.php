<?php declare(strict_types=1);

namespace Airwallex\CommonLibrary\tests\Gateway\AWXClientAPI\Customer;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer\Create;
use Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent\All;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

final class PaymentConsentTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testPaymentConsent(): void
    {
        $response = (new Create())->setCustomerId()->send();
        $arr = json_decode($response, true);
        $this->assertArrayHasKey('id', $arr);
        $customerId = $arr['id'];
        $response = (new All())->setCustomerId($customerId)->send();
        $all = json_decode($response, true);
        $this->assertEmpty($all['items']);
    }
}