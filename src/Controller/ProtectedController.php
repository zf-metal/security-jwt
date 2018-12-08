<?php

namespace ZfMetal\SecurityJwt\Controller;


class ProtectedController extends AbstractProtectedController
{

    public function protectedAction()
    {
        return ["message" => "protected action"];
    }


}
