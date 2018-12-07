<?php

namespace ZfMetal\SecurityJwt\Service;

use Firebase\JWT\JWT;
use ZfMetal\SecurityJwt\Exception\InvalidTokenSuppledException;
use ZfMetal\SecurityJwt\Exception\InvalidUserLoggedInExcetion;
use ZfMetal\SecurityJwt\Options\ModuleOptions;

class JwtService
{
    private $secret_key = 'MaYzkSjmkzPC57L';
    private $encrypt = ['HS256'];

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
    }

    public function signIn(array $data = []): String
    {
        $time = time();

        $token = [
            'exp' => $time + (60 * 60),
            'aud' => $this->getAud(),
            'data' => $data
        ];

        return JWT::encode($token, $this->getSecretKey());
    }

    public function getData(String $token): Array
    {
        return JWT::decode(
            $token,
            $this->getSecretKey(),
            $this->getEncrypt()
        )->data;
    }

    public function checkToken(String $token = null): bool
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
    private function getEncrypt(): Array
    {
        return $this->encrypt;
    }

    // This is only for test testCheckMethodWhenInvalidUserLoggedInReturnAnError
    public function changeAud(): JwtService
    {
        $this->aud = rand(1, 100);
        return $this;
    }

    private function getAud(): String
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HOSTNAME'];
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
