<?php

namespace App\BlockManager\Blocks\LoginForm;

use App\BlockManager\Base\BlockBase;

class LoginFormManager extends BlockBase
{
    public function getTwigTemplate() {
        return '@BlockManagerTemplates/LoginForm/index.html.twig';
    }
}