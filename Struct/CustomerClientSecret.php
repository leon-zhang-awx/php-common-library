<?php

namespace Airwallex\CommonLibrary\Struct;

class CustomerClientSecret extends AbstractBase
{
    /**
     * @var string
     */
    protected $expiredTime;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @return string
     */
    public function getExpiredTime(): string
    {
        return $this->expiredTime;
    }

    /**
     * @param string $expiredTime
     *
     * @return CustomerClientSecret
     */
    public function setExpiredTime(string $expiredTime): CustomerClientSecret
    {
        $this->expiredTime = $expiredTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     *
     * @return CustomerClientSecret
     */
    public function setClientSecret(string $clientSecret): CustomerClientSecret
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }
}
