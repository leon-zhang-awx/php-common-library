<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Airwallex\CommonLibrary\Struct\PaymentConsent;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class Index extends AbstractApi
{
    /**
     * @var string
     */
    protected $paymentConsentId;

    /**
     * @inheritDoc
     */
    protected function getMethod(): string
    {
        return "GET";
    }

    /**
     * @param string $airwallexCustomerId
     *
     * @return Index
     */
    public function setCustomerId(string $airwallexCustomerId): Index
    {
        return $this->setParam('customer_id', $airwallexCustomerId);
    }
    
    /**
     * @param string $status
     *
     * @return Index
     */
    public function setStatus(string $status): Index
    {
        return $this->setParam('status', $status);
    }

    /**
     * @param int $pageNumber
     * @param int $pageSize
     *
     * @return Index
     */
    public function setPage(int $pageNumber = 1, int $pageSize = 20): Index
    {
        return $this->setParam('page_num', $pageNumber)
            ->setParam('page_size', $pageSize);
    }


    /**
     * @param string $triggerReason
     *
     * @return Index
     */
    public function setTriggerReason(string $triggerReason): Index
    {
        return $this->setParam('merchant_trigger_reason', $triggerReason);
    }

    /**
     * @inheritDoc
     */
    protected function getUri(): string
    {
        return 'pa/payment_consents';
    }

    /**
     * @param string $paymentConsentId
     *
     * @return Index
     */
    public function setPaymentConsentId(string $paymentConsentId): Index
    {
        $this->paymentConsentId = $paymentConsentId;
        return $this;
    }


    /**
     * @param string $triggeredBy
     *
     * @return Index
     */
    public function setNextTriggeredBy(string $triggeredBy): Index
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