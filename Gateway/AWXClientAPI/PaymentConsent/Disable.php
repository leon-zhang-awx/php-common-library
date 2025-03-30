<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent;

use Airwallex\CommonLibrary\Configuration\Init;
use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Airwallex\CommonLibrary\Struct\PaymentConsent;
use GuzzleHttp\Psr7\Response;

class Disable extends AbstractApi
{
    /**
     * @var string
     */
    protected $paymentConsentId;

    /**
     * @inheritDoc
     */
    protected function getUri(): string
    {
        return 'pa/payment_consents/' . $this->paymentConsentId . '/disable';
    }

    /**
     * @param string $paymentConsentId
     *
     * @return $this
     */
    public function setPaymentConsentId(string $paymentConsentId): Disable
    {
        $this->paymentConsentId = $paymentConsentId;

        return $this;
    }

    /**
     * @param Response $response
     *
     * @return string
     */
    protected function parseResponse(Response $response): string
    {
        $paymentConsent = new PaymentConsent(json_decode($response->getBody(), true));
        return $paymentConsent->getStatus() === 'DISABLED';
    }
}