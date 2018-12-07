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



}
