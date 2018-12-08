<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 8/12/2018
 * Time: 12:44
 */

namespace ZfMetal\SecurityJwt\Response;


use ZfMetal\Security\Entity\User;

class DoctrineAuthResponse
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
     * @var User
     */
    protected $user;



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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



}