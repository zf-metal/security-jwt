<?php
/**
 * Created by PhpStorm.
 * User: afurgeri
 * Date: 14/03/17
 * Time: 12:56
 */

namespace ZfMetal\SecurityJwt\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use ZfMetal\SecurityJwt\Service\JwtDoctrineIdentity;

class JwtIdentity extends AbstractPlugin
{
    /**
     * @var JwtDoctrineIdentity
     */
    private $jwtDoctrineIdentity;

    /**
     * JwtIdentity constructor.
     * @param JwtDoctrineIdentity $jwtDoctrineIdentity
     */
    public function __construct(JwtDoctrineIdentity $jwtDoctrineIdentity)
    {
        $this->jwtDoctrineIdentity = $jwtDoctrineIdentity;
    }

    function __invoke()
    {
        return $this->jwtDoctrineIdentity->getIdentity();
    }


}