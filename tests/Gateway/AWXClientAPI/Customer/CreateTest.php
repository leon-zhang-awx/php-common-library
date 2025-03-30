<?php declare(strict_types=1);

namespace Airwallex\CommonLibrary\tests\Gateway\AWXClientAPI\Customer;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer\Create;
use Airwallex\CommonLibrary\Struct\Customer;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Exception;

final class CreateTest extends TestCase
{
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function testCustomerCreate()
    {
        /** @var Customer $customer */
        $customer = (new Create())->setCustomerId()->send();
        $this->assertNotEmpty($customer->getId());
    }
}