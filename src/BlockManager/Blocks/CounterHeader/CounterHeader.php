<?php

namespace App\BlockManager\Blocks\CounterHeader;

use App\BlockManager\Base\BlockModelInterface;

class CounterHeader implements BlockModelInterface {
    
    /**
     * custom description on top of counter
     *
     * @var string
     */
    private $description;

    /**
     * Text after counter
     *
     * @var string
     */
    private $textAfterCounter;

    /**
     * Text before counter
     *
     * @var string
     */
    private $textBeforeCounter;

    /**
     * Text on complete
     *
     * @var string
     */
    private $textOnComplete;
    


    /**
     * Get text after counter
     *
     * @return  string
     */ 
    public function getTextAfterCounter()
    {
        return $this->textAfterCounter;
    }

    /**
     * Set text after counter
     *
     * @param  string  $textAfterCounter  Text after counter
     *
     * @return  self
     */ 
    public function setTextAfterCounter(?string $textAfterCounter)
    {
        $this->textAfterCounter = $textAfterCounter;

        return $this;
    }

    /**
     * Get text before counter
     *
     * @return  string
     */ 
    public function getTextBeforeCounter()
    {
        return $this->textBeforeCounter;
    }

    /**
     * Set text before counter
     *
     * @param  string  $textBeforeCounter  Text before counter
     *
     * @return  self
     */ 
    public function setTextBeforeCounter(?string $textBeforeCounter)
    {
        $this->textBeforeCounter = $textBeforeCounter;

        return $this;
    }

    /**
     * Get text on complete
     *
     * @return  string
     */ 
    public function getTextOnComplete()
    {
        return $this->textOnComplete;
    }

    /**
     * Set text on complete
     *
     * @param  string  $textOnComplete  Text on complete
     *
     * @return  self
     */ 
    public function setTextOnComplete(?string $textOnComplete)
    {
        $this->textOnComplete = $textOnComplete;

        return $this;
    }

    /**
     * Get custom description on top of counter
     *
     * @return  string
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set custom description on top of counter
     *
     * @param  string  $description  custom description on top of counter
     *
     * @return  self
     */ 
    public function setDescription(?string $description)
    {
        $this->description = $description;

        return $this;
    }
}