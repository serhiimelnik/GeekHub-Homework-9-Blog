<?php

namespace Melnik\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MelnikUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}