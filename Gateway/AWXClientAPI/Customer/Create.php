<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Airwallex\CommonLibrary\Struct\Customer;
use GuzzleHttp\Psr7\Response;
use Exception;

class Create extends AbstractApi
{
    /**
     * @inheritDoc
     */
    protected function getUri(): string
    {
        return 'pa/customers/create';
    }

    /**
     * @return Create
     *
     * @throws Exception
     */
    public function setCustomerId(): Create
    {
        $merchantCustomerId = substr(bin2hex(random_bytes(10)), 0, 20);
        return $this->setParam('merchant_customer_id', $merchantCustomerId);
    }

    /**
     * @param Response $response
     *
     * @return Customer
     */
    protected function parseResponse(Response $response): Customer
    {
        return new Customer(json_decode($response->getBody(), true));
    }
}