<?php

namespace ZfMetal\SecurityJwt\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use \ZfMetal\SecurityJwt\Controller\Traits\TraitProtectedController;

class ProtectedTraitController extends AbstractActionController
{
    use TraitProtectedController;

    public function protectedAction()
    {
        return ["message" => "Protected by trait"];
    }


}
