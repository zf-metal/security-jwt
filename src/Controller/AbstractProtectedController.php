<?php

namespace ZfMetal\SecurityJwt\Controller;

use Firebase\JWT\JWT;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

use Zend\Mvc\Controller\AbstractActionController;
use ZfMetal\SecurityJwt\Controller\Plugin\ModuleOptions;

/**
 * Class AbstractProtectedController
 * @method ModuleOptions getSecurityJwtOptions()
 * @package ZfMetal\SecurityJwt\Controller
 */
abstract class AbstractProtectedController extends AbstractActionController
{

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->getSecurityJwtOptions()->getModuleOptions()->getSecretKey();
    }

    /**
     * @return array
     */
    public function getEncrypt()
    {
        return $this->getSecurityJwtOptions()->getModuleOptions()->getEncrypt();
    }



    /**
     * Validate if a token is provided in the header Authorization, after the prefix "Bearer ".
     * If the token isn't provided, returns a 401 response.
     * If the token is invalid, returns a 401 response.
     *
     * @param MvcEvent $e
     * @return mixed|\Zend\Stdlib\ResponseInterface
     */
    public function onDispatch(MvcEvent $e)
    {
        $request = $e->getRequest();
        $authorizationHeader = $request->getHeaders()->get('Authorization');
        if (!$authorizationHeader) {
            $response = $e->getResponse();
            $response->setStatusCode(401);
            return $response;
        }
        $token = str_replace("Bearer ", "", $authorizationHeader->getFieldValue());

        try {
            JWT::decode($token, $this->getSecretKey(), $this->getEncrypt());
            return parent::onDispatch($e);
        } catch (Exception $exception) {
            $response = $e->getResponse()->setStatusCode(401);
            return $response;
        }
    }


}
