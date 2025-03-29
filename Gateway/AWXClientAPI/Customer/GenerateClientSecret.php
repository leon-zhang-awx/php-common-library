<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\Customer;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Airwallex\CommonLibrary\Struct\CustomerClientSecret;
use Psr\Http\Message\ResponseInterface;

class GenerateClientSecret extends AbstractApi
{
    protected $customerId;

    protected function getMethod()
    {
        return 'GET';
    }

    /**
     * Returns the API endpoint URI for creating a customer.
     *
     * @return string API URL endpoint
     */
    protected function getUri(): string
    {
        return 'pa/customers/' . $this->customerId . '/generate_client_secret';
    }

    /**
     * Sets the customer ID.
     *
     * @return self Returns instance for method chaining
     */
    public function setCustomerId(string $customerId): self
    {
        $this->customerId = $customerId;
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
        return new CustomerClientSecret(json_decode($response->getBody(), true));
    }
}