<?php declare(strict_types=1);

namespace Airwallex\CommonLibrary\tests\Gateway\AWXClientAPI;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\Authentication;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

final class AuthenticateTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testAuthentication(): void
    {
        $response = (new Authentication())->send();
        $this->assertObjectHasProperty('token', $response);
    }
}