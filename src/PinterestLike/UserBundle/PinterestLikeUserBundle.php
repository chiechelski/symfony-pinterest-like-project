<?php

namespace PinterestLike\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PinterestLikeUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
