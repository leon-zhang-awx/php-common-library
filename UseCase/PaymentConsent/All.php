<?php

namespace Airwallex\CommonLibrary\UseCase\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent\Index;
use Airwallex\CommonLibrary\Struct\PaymentConsent;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class All
{
    /**
     * @var string
     */
    const STATUS_VERIFIED = 'VERIFIED';

    /**
     * @var string
     */
    const TRIGGERED_BY_CUSTOMER = 'customer';

    /**
     * @var string
     */
    const TRIGGERED_BY_MERCHANT = 'merchant';

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
                $res = (new Index())
                    ->setCustomerId($this->customerId)
                    ->setNextTriggeredBy($this->triggeredBy)
                    ->setPage($index)
                    ->send();

                $index++;
                $resArr = json_decode($res, true);
                if (!empty($resArr['items'])) {
                    foreach ($resArr['items'] as $item) {
                        $obj = new PaymentConsent($item);
                        if ($obj->getStatus() === self::STATUS_VERIFIED) {
                            $all[] = $obj;
                        }
                    }
                }
                if (empty($resArr['has_more'])) {
                    break;
                }
            }
        } catch (Exception $e) {}
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