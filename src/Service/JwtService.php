<?php

namespace ZfMetal\SecurityJwt\Service;

use Firebase\JWT\JWT;
use ZfMetal\SecurityJwt\Exception\InvalidTokenSuppledException;
use ZfMetal\SecurityJwt\Exception\InvalidUserLoggedInExcetion;
use ZfMetal\SecurityJwt\Options\ModuleOptions;

class JwtService
{
    private $secret_key;
    private $encrypt = ['HS256'];
    private $expiryTime = 3600;

    /**
     * @var ModuleOptions
     */
    private $options;


    // This is only for test testCheckMethodWhenInvalidUserLoggedInReturnAnError
    private $aud = null;

    /**
     * JwtService constructor.
     * @param ModuleOptions $options
     */
    public function __construct(ModuleOptions $options)
    {
        $this->options = $options;
        $this->secret_key = $this->options->getSecretKey();
        $this->encrypt = $this->options->getEncrypt();
        $this->expiryTime = $this->options->getExpiryTime();
    }

    public function signIn(array $data = [])
    {
        $time = time();

        $token = [
            'exp' => $time + $this->getExpiryTime(),
            'aud' => $this->getAud(),
            'data' => $data
        ];

        return JWT::encode($token, $this->getSecretKey());
    }

    public function getData($token)
    {
        return JWT::decode(
            $token,
            $this->getSecretKey(),
            $this->getEncrypt()
        )->data;
    }

    public function checkToken($token = null)
    {
        if (empty($token)) {
            throw new InvalidTokenSuppledException("Invalid token supplied.");
        }
        $decode = JWT::decode(
            $token,
            $this->getSecretKey(),
            $this->getEncrypt()
        );
        if ($decode->aud !== $this->getAud()) {
            throw new InvalidUserLoggedInExcetion("Invalid user logged in.");
        }

        return true;
    }

    /**
     * Get the value of Secret Key
     *
     * @return mixed
     */
    private function getSecretKey()
    {
        return $this->secret_key;
    }

    /**
     * Get the value of Encrypt
     *
     * @return array
     */
    private function getEncrypt()
    {
        return $this->encrypt;
    }

    /**
     * @return int
     */
    public function getExpiryTime()
    {
        return $this->expiryTime;
    }



    // This is only for test testCheckMethodWhenInvalidUserLoggedInReturnAnError
    public function changeAud()
    {
        $this->aud = rand(1, 100);
        return $this;
    }

    private function getAud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $aud = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['HOSTNAME'])) {
            $aud = $_SERVER['HOSTNAME'];
        } else {
            $aud = 'LOCAL';
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        // This is only for test testCheckMethodWhenInvalidUserLoggedInReturnAnError
        if ($this->aud) {
            $aud .= $this->aud;
        }
        $this->aud = null;

        return sha1($aud);
    }
}
