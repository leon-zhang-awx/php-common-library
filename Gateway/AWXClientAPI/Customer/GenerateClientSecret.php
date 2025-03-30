<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Airwallex\CommonLibrary\Struct\CustomerClientSecret;
use GuzzleHttp\Psr7\Response;

class GenerateClientSecret extends AbstractApi
{
    /**
     * @var string
     */
    protected $customerId;

    /**
     * @inheritDoc
     */
    protected function getMethod(): string
    {
        return 'GET';
    }

    /**
     * @inheritDoc
     */
    protected function getUri(): string
    {
        return 'pa/customers/' . $this->customerId . '/generate_client_secret';
    }

    /**
     * @param string $customerId
     *
     * @return GenerateClientSecret
     */
    public function setCustomerId(string $customerId): self
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @param Response $response
     * @return CustomerClientSecret
     */
    protected function parseResponse(Response $response): CustomerClientSecret
    {
        return new CustomerClientSecret(json_decode($response->getBody(), true));
    }
}