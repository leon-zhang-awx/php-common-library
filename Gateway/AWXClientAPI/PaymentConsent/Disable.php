<?php

namespace Airwallex\CommonLibrary\Gateway\AWXClientAPI\PaymentConsent;

use Airwallex\CommonLibrary\Gateway\AWXClientAPI\AbstractApi;
use Psr\Http\Message\ResponseInterface;

class Disable extends AbstractApi
{
    protected $paymentConsentId = null;

    /**
     * Returns the API endpoint URI for creating a customer.
     *
     * @return string API URL endpoint
     */
    protected function getUri(): string
    {
        return 'pa/payment_consents/' . $this->paymentConsentId . '/disable';
    }

    /**
     * @param string $paymentConsentId
     * @return $this
     */
    public function setPaymentConsentId(string $paymentConsentId): Disable
    {
        $this->paymentConsentId = $paymentConsentId;

        return $this;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return string
     */
    protected function parseResponse($response): string
    {
        $response = $this->parseJson($response);

        return $response->status === 'DISABLED';
    }
}