<?php

namespace Airwallex\CommonLibrary\UseCase\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent\GetList;
use Airwallex\CommonLibrary\Struct\PaymentConsent;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class All
{
    /**
     * @var string
     */
    protected $triggeredBy;

    /**
     * @var string
     */
    protected $customerId;

    /**
     * @return array
     * @throws GuzzleException
     */
    public function get(): array
    {
        $index = 0;
        $all = [];
        try {
            while (true) {
                $list = (new GetList())
                    ->setCustomerId($this->customerId)
                    ->setNextTriggeredBy($this->triggeredBy)
                    ->setPage($index)
                    ->setStatus(PaymentConsent::STATUS_VERIFIED)
                    ->send();

                if (empty($list)) {
                    break;
                }
                /** @var PaymentConsent $paymentConsent */
                foreach ($list as $paymentConsent) {
                    $all[] = $paymentConsent;
                }

                $index++;
            }
        } catch (Exception $e) {
        }
        return $all;
    }

    /**
     * @param string $triggeredBy
     *
     * @return All
     */
    public function setNextTriggeredBy(string $triggeredBy): All
    {
        $this->triggeredBy = $triggeredBy;
        return $this;
    }

    /**
     * @param string $airwallexCustomerId
     *
     * @return All
     */
    public function setCustomerId(string $airwallexCustomerId): All
    {
        $this->customerId = $airwallexCustomerId;
        return $this;
    }
}