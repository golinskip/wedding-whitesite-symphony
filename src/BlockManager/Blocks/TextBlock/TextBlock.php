<?php

namespace App\BlockManager\Blocks\TextBlock;

use App\BlockManager\Base\BlockModelInterface;

class TextBlock implements BlockModelInterface {
    public $content;
    
    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
}