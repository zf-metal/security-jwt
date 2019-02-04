<?php

namespace ZfMetal\SecurityJwt\Controller;


use Zend\View\Model\JsonModel;
use ZfMetal\Security\Entity\Permission;
use ZfMetal\Security\Entity\Role;
use ZfMetal\Security\Entity\User;
use ZfMetal\SecurityJwt\Controller\Plugin\JwtIdentity;
use ZfMetal\SecurityJwt\Response\JwtResponse;
use ZfMetal\SecurityJwt\Service\JwtDoctrineAuth;
use ZfMetal\SecurityJwt\Service\JwtService;
use Zend\Mvc\Controller\AbstractActionController;


/**
 * Class JwtController
 * @method JwtIdentity getJwtIdentity
 * @package ZfMetal\SecurityJwt\Controller
 */
class JwtController extends AbstractActionController
{

    /**
     *
     * @var JwtService
     */
    private $jwtService;


    /**
     * @var JwtDoctrineAuth
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
     * @param JwtDoctrineAuth $doctrineAuth
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(JwtService $jwtService, JwtDoctrineAuth $doctrineAuth, \Doctrine\ORM\EntityManager $em)
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

    private function getImgFullPath()
    {
        $baseUrl = "";
        try {
            $baseUrl = $this->getSecurityOptions()->getHttpHost();
        } catch (\Exception $e) {

        }
        return $baseUrl;
    }


    public function authAction()
    {

        $jwtResponse = new JwtResponse();

        $username = $this->getRequest()->getPost('username');
        $password = $this->getRequest()->getPost('password');

        if (!$username || !$password) {
            $this->getResponse()->setStatusCode(422);
            $jwtResponse->setMessage("Missing Params. username and password required.");
        } else {

            //Autentico con Doctrine
            $doctrineAuthResponse = $this->doctrineAuth->authenticate($username, $password);

            //Traslado el mensaje y resultado obtendido en JwtDoctrineAuth a la JwtResponse
            $jwtResponse->setMessage($doctrineAuthResponse->getMessage());
            $jwtResponse->setSuccess($doctrineAuthResponse->isSuccess());


            //Si la autenticacion de doctrine es positiva genero el token
            if ($doctrineAuthResponse->isSuccess()) {

                $img = $this->getSecurityOptions()->getHttpHost() .
                    \ZfMetal\Security\Constants::IMG_RELATIVE_PATH .
                    $doctrineAuthResponse->getUser()->getImg();

                $roles = [];

                /**
                 * @var $role Role
                 */
                foreach($doctrineAuthResponse->getUser()->getRoles() as $role){

                    $permissions= [];

                    /** @var Permission $permission */
                    foreach($role->getPermissions() as $permission){
                        $permissions[] = $permission->getName();
                    }

                    $roles[] = ["id" => $role->getId(), "name"=> $role->getName(), "permissions" => $permissions];
                }


                $data = [
                    'id' => $doctrineAuthResponse->getUser()->getId(),
                    'username' => $doctrineAuthResponse->getUser()->getUsername(),
                    'name' => $doctrineAuthResponse->getUser()->getName(),
                    'email' => $doctrineAuthResponse->getUser()->getEmail(),
                    'phone' => $doctrineAuthResponse->getUser()->getPhone(),
                    'img' => $img,
                    'roles' => $doctrineAuthResponse->getUser()->getRoles()->toArray(),
                    'roles' => $roles

                ];

                $token = $this->getJwtService()->signIn($data);

                //Seteo el token generado a jwtResponse
                $jwtResponse->setToken($token);
            } else {
                $this->getResponse()->setStatusCode(401);
            }

        }

        //Retorno la jwtResponse claves: success, message, token(si se genera) en formato JSON
        return new JsonModel($jwtResponse->toArray());

    }


    public function myIdentityAction()
    {
        /** @var User $user */
        $user = $this->getJwtIdentity();

        if ($user) {
            $json = [
                'id' => $user->getId(),
                'username' => $user->getUsername()
            ];
        } else {
            return $this->getResponse()->setStatusCode(401);
        }

        return new JsonModel($json);

    }


}
