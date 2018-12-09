<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 8/12/2018
 * Time: 12:28
 */

namespace ZfMetal\SecurityJwt\Service;


use Zend\Crypt\Password\Bcrypt;
use Zend\Http\Request;
use ZfMetal\Security\Entity\User;
use ZfMetal\Security\Repository\UserRepository;
use ZfMetal\SecurityJwt\Response\DoctrineAuthResponse;

class JwtDoctrineIdentity
{

    /**
     * @var Request
     */
    private $request;

    /**
     *
     * @var JwtService
     */
    private $jwtService;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var User
     */
    protected $identity;

    /**
     * JwtDoctrineIdentity constructor.
     * @param Request $request
     * @param JwtService $jwtService
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(Request $request, JwtService $jwtService, \Doctrine\ORM\EntityManager $em)
    {
        $this->request = $request;
        $this->jwtService = $jwtService;
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

    public function getTokenFromRequest(){
        if(!$this->token){
            $authorizationHeader = $this->request->getHeaders()->get('Authorization');
            if($authorizationHeader) {
                $this->token = str_replace("Bearer ", "", $authorizationHeader->getFieldValue());
            }
        }

        return $this->token;
    }

    /**
     * Retorna el usuario identificado por el token de jwt
     * @return null|User
     */
    public function getIdentity(){
        if(!$this->identity){
            if($this->getTokenFromRequest()) {
                $data = $this->jwtService->getData($this->getTokenFromRequest());
                $id = $data->id;
                $this->identity = $this->getUserRepository()->find($id);
            }
        }

        return $this->identity;
    }



}