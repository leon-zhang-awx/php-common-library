<?php declare(strict_types=1);

namespace Airwallex\CommonLibrary\tests\UseCase\PaymentConsent;

use Airwallex\CommonLibrary\UseCase\PaymentConsent\All;
use PHPUnit\Framework\TestCase;

final class AllTest extends TestCase
{
    public function testCustomerCreate()
    {
        $all = (new All())->setNextTriggeredBy(All::TRIGGERED_BY_CUSTOMER)->setCustomerId('cus_hkdm7kv89gnrhfzy4g3')->get();
    }
}