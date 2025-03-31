<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Airwallex\CommonLibrary\Struct\PaymentConsent;
use GuzzleHttp\Psr7\Response;
use Airwallex\CommonLibrary\Struct\GetList as StructGetList;

class GetList extends AbstractApi
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
     * @return GetList
     */
    public function setCustomerId(string $airwallexCustomerId): GetList
    {
        return $this->setParam('customer_id', $airwallexCustomerId);
    }

    /**
     * @param string $status
     *
     * @return GetList
     */
    public function setStatus(string $status): GetList
    {
        return $this->setParam('status', $status);
    }

    /**
     * @param int $pageNumber
     * @param int $pageSize
     *
     * @return GetList
     */
    public function setPage(int $pageNumber = 0, int $pageSize = 1000): GetList
    {
        return $this->setParam('page_num', $pageNumber)
            ->setParam('page_size', $pageSize);
    }


    /**
     * @param string $triggerReason
     *
     * @return GetList
     */
    public function setTriggerReason(string $triggerReason): GetList
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
     * @return GetList
     */
    public function setPaymentConsentId(string $paymentConsentId): GetList
    {
        $this->paymentConsentId = $paymentConsentId;
        return $this;
    }


    /**
     * @param string $triggeredBy
     *
     * @return GetList
     */
    public function setNextTriggeredBy(string $triggeredBy): GetList
    {
        return $this->setParam('next_triggered_by', $triggeredBy);
    }

    /**
     * @param Response $response
     *
     * @return StructGetList
     */
    protected function parseResponse(Response $response): StructGetList
    {
        $items = [];
        $responseArray = json_decode($response->getBody(), true);
        if (!empty($responseArray['items'])) {
            foreach ($responseArray['items'] as $item) {
                $items[] = new PaymentConsent($item);
            }
        }
        return new StructGetList([
            'items' => $items,
            'has_more' => $responseArray['has_more'],
        ]);
    }
}