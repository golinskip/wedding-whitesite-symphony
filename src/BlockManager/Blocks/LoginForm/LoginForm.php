<?php

namespace App\BlockManager\Blocks\LoginForm;

use App\BlockManager\Base\BlockModelInterface;

class LoginForm implements BlockModelInterface {
    const STYLE_LINE = 0;
    const STYLE_TWO_BLOCKS = 1;

    private $placeholder;

    private $button_text;

    private $help_text;

    private $title_text;

    private $width;

    private $style;

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

    /**
     * Get the value of placeholder
     */ 
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set the value of placeholder
     *
     * @return  self
     */ 
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the value of help_text
     */ 
    public function getHelpText()
    {
        return $this->help_text;
    }

    /**
     * Set the value of help_text
     *
     * @return  self
     */ 
    public function setHelpText($help_text)
    {
        $this->help_text = $help_text;

        return $this;
    }

    /**
     * Get the value of title_text
     */ 
    public function getTitleText()
    {
        return $this->title_text;
    }

    /**
     * Set the value of title_text
     *
     * @return  self
     */ 
    public function setTitleText($title_text)
    {
        $this->title_text = $title_text;

        return $this;
    }

    /**
     * Get the value of width
     */ 
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the value of width
     *
     * @return  self
     */ 
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get the value of style
     */ 
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set the value of style
     *
     * @return  self
     */ 
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }
}
