<?php

namespace App\BlockManager\Blocks\TextBlock;

class TextBlock {
    public $content;
    
    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
}