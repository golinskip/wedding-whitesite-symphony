<?php

namespace App\BlockManager\Blocks\TextBlock;

use App\BlockManager\Base\BlockBase;

class TextBlockManager extends BlockBase
{
    public function getTwigTemplate() {
        return '@BlockManagerTemplates/TextBlock/index.html.twig';
    }
}