<?php

namespace App\BlockManager\Blocks\GoogleMaps;

use App\BlockManager\Base\BlockBase;

class GoogleMapsManager extends BlockBase
{
    public function getTwigTemplate() {
        return '@BlockManagerTemplates/GoogleMaps/index.html.twig';
    }
}