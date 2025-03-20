<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent;

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
        return 'pa/payment_consents/create';
    }

    /**
     * Sets the customer ID.
     *
     * @return self Returns instance for method chaining
     */
    public function setCustomerId(string $id): self
    {
        return $this->setParam('customer_id', $id);
    }

    /**
     * @param string $triggeredBy
     * @return Create
     */
    public function setNextTriggeredBy(string $triggeredBy)
    {
        return $this->setParam('next_triggered_by', $triggeredBy);
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