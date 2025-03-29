<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Airwallex\Struct\Customer;
use Psr\Http\Message\ResponseInterface;

class Retreive extends AbstractApi
{
    protected $id;

    /**
     * Returns the API endpoint URI for creating a customer.
     *
     * @return string API URL endpoint
     */
    protected function getUri(): string
    {
        return 'pa/customers/' . $this->id;
    }

    protected function getMethod()
    {
        return 'GET';
    }

    /**
     * Sets the customer ID.
     *
     * @return self Returns instance for method chaining
     */
    public function setCustomerId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Parses the API response and returns the raw response body.
     *
     * @param ResponseInterface $response HTTP response object
     * @return string Parsed response as a raw string
     */
    protected function parseResponse($response)
    {
        return new Customer(json_decode($response->getBody(), true));
    }
}