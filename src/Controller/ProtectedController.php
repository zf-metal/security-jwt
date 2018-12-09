<?php

namespace ZfMetal\SecurityJwt\Controller;


class ProtectedController extends AbstractProtectedController
{

    public function protectedAction()
    {
        return ["message" => "Protected by AbstractProtected"];
    }


}
