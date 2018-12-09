<?php

namespace ZfMetal\SecurityJwt\Options;

use Zend\Stdlib\AbstractOptions;
use ZfcRbac\Options\RedirectStrategyOptions;

/**
 */
class ModuleOptions extends AbstractOptions
{

    /**
     * Secret Key
     *
     * @var string
     */
    protected $secretKey = 'MaYzkSjmkzPC57L';


    /**
     * @var array
     */
    protected $encrypt = ['HS256'];

    /**
     * Expiry Time in Seconds
     * @var int
     */
    protected $expiryTime = 3600;

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return array
     */
    public function getEncrypt()
    {
        return $this->encrypt;
    }

    /**
     * @param array $encrypt
     */
    public function setEncrypt($encrypt)
    {
        $this->encrypt = $encrypt;
    }

    /**
     * @return int
     */
    public function getExpiryTime()
    {
        return $this->expiryTime;
    }

    /**
     * @param int $expiryTime
     */
    public function setExpiryTime($expiryTime)
    {
        $this->expiryTime = $expiryTime;
    }



}
