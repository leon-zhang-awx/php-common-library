<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Psr\Http\Message\ResponseInterface;

class Index extends AbstractApi
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
     * @return $this
     */
    public function setCustomerId(string $airwallexCustomerId): self
    {
        return $this->setParam('customer_id', $airwallexCustomerId);
    }
    
    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        return $this->setParam('status', $status);
    }

    /**
     * @param int $pageNumber
     * @param int $pageSize
     * @return $this
     */
    public function setPage(int $pageNumber = 1, int $pageSize = 20): self
    {
        return $this->setParam('page_num', $pageNumber)
            ->setParam('page_size', $pageSize);
    }


    /**
     * @param string $triggerReason
     * @return $this
     */
    public function setTriggerReason(string $triggerReason): self
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
    public function setPaymentConsentId(string $paymentConsentId): self
    {
        $this->paymentConsentId = $paymentConsentId;

        return $this;
    }


    /**
     * @param string $triggeredBy
     * @return $this
     */
    public function setNextTriggeredBy(string $triggeredBy): self
    {
        return $this->setParam('next_triggered_by', $triggeredBy);
    }

    /**
     * Parses the API response and returns the raw response body.
     *
     * @param ResponseInterface $response HTTP response object
     */
    protected function parseResponse($response): string
    {
        return (string) $response->getBody();
    }
}