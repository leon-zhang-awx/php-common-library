<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Psr\Http\Message\ResponseInterface;

class Create extends AbstractApi
{
    /**
     * Returns the API endpoint URI for creating a customer.
     *
     * @return string API URL endpoint
     */
    protected function getUri(): string
    {
        return 'pa/customers/create';
    }

    /**
     * Sets the customer ID.
     *
     * @return self Returns instance for method chaining
     */
    public function setCustomerId(): self
    {
        return $this->setParam('merchant_customer_id', substr(bin2hex(random_bytes(10)), 0, 20));
    }

    /**
     * Parses the API response and returns the raw response body.
     *
     * @param ResponseInterface $response HTTP response object
     * @return string Parsed response as a raw string
     */
    protected function parseResponse($response): string
    {
        return (string) $response->getBody();
    }
}