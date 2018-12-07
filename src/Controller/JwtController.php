<?php

namespace ZfMetal\SecurityJwt\Controller;

use Jwt\Service\JwtService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class JwtController extends AbstractActionController {

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
     * JwtController constructor.
     * @param JwtService $jwtService
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(JwtService $jwtService, \Doctrine\ORM\EntityManager $em)
    {
        $this->jwtService = $jwtService;
        $this->em = $em;
    }

    /**
     * @return JwtService
     */
    public function getJwtService()
    {
        return $this->jwtService;
    }




    function getEm() {
        return $this->em;
    }


    public function loginAction() {

    }

    public function logoutAction() {

    }



}
