<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Psr\Http\Message\ResponseInterface;

class All extends AbstractApi
{
    protected $paymentConsentId = null;

    /**
     * @return string
     */
    protected function getMethod(): string
    {
        return "GET";
    }

    /**
     * @param string $airwallexCustomerId
     * @return All
     */
    public function setCustomerId(string $airwallexCustomerId)
    {
        return $this->setParam('customer_id', $airwallexCustomerId);
    }

    /**
     * @param int $pageNumber
     * @param int $pageSize
     * @return All
     */
    public function setPage(int $pageNumber, int $pageSize = 20)
    {
        return $this->setParam('page_num', $pageNumber)
            ->setParam('page_size', $pageSize);
    }


    /**
     * @param string $triggerReason
     * @return All
     */
    public function setTriggerReason(string $triggerReason)
    {
        return $this->setParam('merchant_trigger_reason', $triggerReason);
    }

    /**
     * Returns the API endpoint URI for creating a customer.
     *
     * @return string API URL endpoint
     */
    protected function getUri(): string
    {
        return 'pa/payment_consents';
    }

    /**
     * @param string $paymentConsentId
     * @return $this
     */
    public function setPaymentConsentId(string $paymentConsentId): All
    {
        $this->paymentConsentId = $paymentConsentId;

        return $this;
    }


    /**
     * @param string $triggeredBy
     * @return All
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
    protected function parseResponse(ResponseInterface $response): string
    {
        return (string) $response->getBody();
    }
}