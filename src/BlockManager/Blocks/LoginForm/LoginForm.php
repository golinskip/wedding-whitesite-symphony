<?php

namespace App\BlockManager\Blocks\LoginForm;

use App\BlockManager\Base\BlockModelInterface;

class LoginForm implements BlockModelInterface {
    private $button_text;

    /**
     * Get the value of button_text
     */ 
    public function getButtonText()
    {
        return $this->button_text;
    }

    /**
     * Set the value of button_text
     *
     * @return  self
     */ 
    public function setButtonText($button_text)
    {
        $this->button_text = $button_text;

        return $this;
    }
}
