<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Airwallex\CommonLibrary\Struct\PaymentConsent;
use GuzzleHttp\Psr7\Response;

class Create extends AbstractApi
{
    /**
     * @inheritDoc
     */
    protected function getUri(): string
    {
        return 'pa/payment_consents/create';
    }

    /**
     * @param string $id
     *
     * @return Create
     */
    public function setCustomerId(string $id): self
    {
        return $this->setParam('customer_id', $id);
    }

    /**
     * @param string $triggeredBy
     *
     * @return Create
     */
    public function setNextTriggeredBy(string $triggeredBy): Create
    {
        return $this->setParam('next_triggered_by', $triggeredBy);
    }

    /**
     * @param Response $response
     *
     * @return PaymentConsent
     */
    protected function parseResponse(Response $response): PaymentConsent
    {
        return new PaymentConsent(json_decode($response->getBody(), true));
    }
}