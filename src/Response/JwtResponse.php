<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 8/12/2018
 * Time: 12:44
 */

namespace ZfMetal\SecurityJwt\Response;


class JwtResponse
{

    /**
     * @var boolean
     */
    protected $success = false;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $token;


    public function toArray()
    {

        $response = [
            "success" => $this->success,
            "message" => $this->message,
        ];

        //Add Token IF is SET
        if ($this->token) {
            $response["token"] = $this->token;
        }

        return $response;
    }

    public function toJson(){
        return json_encode($this->toArray());
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }


}