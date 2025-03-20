<?php

namespace Airwallex\CommonLibrary\UseCase\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent\Index;
use Airwallex\CommonLibrary\Struct\PaymentConsent;

class All
{
    const STATUS_VERIFIED = 'VERIFIED';
    const TRIGGERED_BY_CUSTOMER = 'customer';
    const TRIGGERED_BY_MERCHANT = 'merchant';
    protected $triggeredBy;
    protected $customerId;



    public function get()
    {
        $index = 0;
        $all = [];
        try {
            while (true) {
                $res = (new Index())
                    ->setCustomerId($this->customerId)
                    ->setNextTriggeredBy($this->triggeredBy)

                    ->setPage($index,20)
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
                if (!$resArr['has_more']) {
                    break;
                }
            }
        } catch (\Exception $e) {}
        return $all;
    }

    public function setNextTriggeredBy(string $triggeredBy): self
    {
        $this->triggeredBy = $triggeredBy;
        return $this;
    }

    public function setCustomerId(string $airwallexCustomerId): self
    {
        $this->customerId = $airwallexCustomerId;
        return $this;
    }
}