<?php

namespace Airwallex\CommonLibrary\Struct;

class CustomerClientSecret extends AbstractBase {

    protected $expiredTime;
    protected $clientSecret;

    /**
     * Get expired time
     *
     * @return mixed
     */
    public function getExpiredTime() {
        return $this->expiredTime;
    }

    /**
     * Set expired time
     *
     * @param mixed $id
     * @return CustomerClientSecret
     */
    public function setExpiredTime( $expiredTime ) {
        $this->expiredTime = $expiredTime;
        return $this;
    }

    /**
     * Get client secret
     *
     * @return string|null
     */
    public function getClientSecret() {
        return $this->clientSecret;
    }

    /**
     * Set client secret
     *
     * @param string $clientSecret
     * @return CustomerClientSecret
     */
    public function setClientSecret( $clientSecret ) {
        $this->clientSecret = $clientSecret;
        return $this;
    }
}
