<?php

namespace Sport\Bundle\AppSecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppSecurityBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
