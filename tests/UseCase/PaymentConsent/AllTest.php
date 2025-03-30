<?php declare(strict_types=1);

namespace Airwallex\CommonLibrary\tests\UseCase\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer\Create;
use Airwallex\CommonLibrary\UseCase\PaymentConsent\All;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

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
            ->setNextTriggeredBy(All::TRIGGERED_BY_CUSTOMER)
            ->setCustomerId('cus_hkdm7kv89gnrhfzy4g3')
            ->get();
        $this->assertCount(0, $all);
    }
}