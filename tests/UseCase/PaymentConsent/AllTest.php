<?php declare(strict_types=1);

namespace Airwallex\CommonLibrary\tests\UseCase\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer\Create;
use Airwallex\CommonLibrary\UseCase\PaymentConsent\All;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Airwallex\CommonLibrary\Struct\PaymentConsent;

final class AllTest extends TestCase
{
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function testCustomerCreate()
    {
        $customer = (new Create())->setCustomerId()->send();
        $all = (new All())
            ->setNextTriggeredBy(PaymentConsent::TRIGGERED_BY_CUSTOMER)
            ->setCustomerId($customer->getId())
            ->get();
        $this->assertCount(0, $all);
    }
}