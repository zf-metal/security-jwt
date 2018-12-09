<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 8/12/2018
 * Time: 12:28
 */

namespace ZfMetal\SecurityJwt\Service;


use Zend\Crypt\Password\Bcrypt;
use ZfMetal\Security\Entity\User;
use ZfMetal\Security\Repository\UserRepository;
use ZfMetal\SecurityJwt\Response\DoctrineAuthResponse;

class JwtDoctrineAuth
{


    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * JwtDoctrineAuth constructor.
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }


    /**
     * @return  UserRepository
     */
    protected function getUserRepository(){
        return $this->getEm()->getRepository(User::class);
    }

    /**
     * @param $identity
     * @param $password
     * @return DoctrineAuthResponse
     */
    public function authenticate($identity,$password) {

        $bcrypt = new Bcrypt();
        $bcrypt->setCost(12);

        $user = $this->getUserRepository()->getAuthenticateByEmailOrUsername($identity);

        $response = new DoctrineAuthResponse();
        $response->setSuccess(false);

        if ($user) {
            if (!$user->isActive()) {
                $response->setMessage('Inactive user');
            } else if ($bcrypt->verify($password, $user->getPassword())) {
                $response->setMessage('Authentication successful');
                $response->setSuccess(true);
                $response->setUser($user);
                $this->forceGetRole($user);
            } else {
                $response->setMessage('Invalid Credentials');
            }
        } else {
            //User doesn't exist
            $response->setMessage('Invalid Credentials');
        }

        return $response;
    }

    /**
     * Workaround para que la entity busque en la DB los roles y los tenga en memoria
     * TODO ver si se puede resolver desde la misma query
     * @param User $user
     */
    protected function forceGetRole(User $user){

        $user->getRoles()->getValues();
    }

}