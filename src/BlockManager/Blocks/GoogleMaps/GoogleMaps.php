<?php

namespace App\BlockManager\Blocks\GoogleMaps;

use App\BlockManager\Base\BlockModelInterface;

class GoogleMaps implements BlockModelInterface {
    const LAYOUT_TEXT_TOP = 0;
    const LAYOUT_TEXT_LEFT = 1;
    const LAYOUT_TEXT_RIGHT = 2;

    /**
     * Description
     *
     * @var string
     */
    protected $description;

    /**
     * Layout of map block
     *
     * @var integer
     */
    protected $layout;

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $code;

    

    /**
     * Get description
     *
     * @return  string
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param  string  $description  Description
     *
     * @return  self
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get layout of map block
     *
     * @return  integer
     */ 
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set layout of map block
     *
     * @param  integer  $layout  Layout of map block
     *
     * @return  self
     */ 
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $code  Undocumented variable
     *
     * @return  self
     */ 
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    public static function getLayouts() {
        return [
            'Description on top' => self::LAYOUT_TEXT_TOP,
            'Description on left' => self::LAYOUT_TEXT_LEFT,
            'Description on right' => self::LAYOUT_TEXT_RIGHT,
        ];
    }
}