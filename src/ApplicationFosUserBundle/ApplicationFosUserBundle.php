<?php

namespace ApplicationFosUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationFosUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
