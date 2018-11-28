<?php

namespace App\BlockManager\Blocks\CounterHeader;

use App\BlockManager\Base\BlockBase;

class CounterHeaderManager extends BlockBase
{
    public function getTwigTemplate() {
        return '@BlockManagerTemplates/CounterHeader/index.html.twig';
    }
}