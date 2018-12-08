<?php

namespace ZfMetal\SecurityJwt\Controller;

use http\Exception\BadMethodCallException;
use Zend\View\Model\JsonModel;
use ZfMetal\SecurityJwt\Response\JwtResponse;
use ZfMetal\SecurityJwt\Service\DoctrineAuth;
use ZfMetal\SecurityJwt\Service\JwtService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class JwtController extends AbstractActionController
{

    /**
     *
     * @var JwtService
     */
    private $jwtService;


    /**
     * @var DoctrineAuth
     */
    protected $doctrineAuth;


    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;


    /**
     * JwtController constructor.
     * @param JwtService $jwtService
     * @param DoctrineAuth $doctrineAuth
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(JwtService $jwtService, DoctrineAuth $doctrineAuth, \Doctrine\ORM\EntityManager $em)
    {
        $this->jwtService = $jwtService;
        $this->doctrineAuth = $doctrineAuth;
        $this->em = $em;
    }


    /**
     * @return JwtService
     */
    public function getJwtService()
    {
        return $this->jwtService;
    }


    function getEm()
    {
        return $this->em;
    }


    public function authAction()
    {

        $jwtResponse = new JwtResponse();

        $username = $this->getRequest()->getPost('username');
        $password = $this->getRequest()->getPost('password');

        if (!$username || !$password) {
            $jwtResponse->setMessage("Missing Params. username and password required.");
        }else {

            //Autentico con Doctrine
            $doctrineAuthResponse = $this->doctrineAuth->authenticate($username, $password);

            //Traslado el mensaje y resultado obtendido en DoctrineAuth a la JwtResponse
            $jwtResponse->setMessage($doctrineAuthResponse->getMessage());
            $jwtResponse->setSuccess($doctrineAuthResponse->isSuccess());


            //Si la autenticacion de doctrine es positiva genero el token
            if ($doctrineAuthResponse->isSuccess()) {

                $data = [
                    'id' => $doctrineAuthResponse->getUser()->getId(),
                    'username' => $doctrineAuthResponse->getUser()->getUsername(),
                ];

                $token = $this->getJwtService()->signIn($data);

                //Seteo el token generado a jwtResponse
                $jwtResponse->setToken($token);
            }

        }

        //Retorno la jwtResponse claves: success, message, token(si se genera) en formato JSON
        return new JsonModel($jwtResponse->toArray());

    }


}
