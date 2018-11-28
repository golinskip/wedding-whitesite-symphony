<?php

namespace App\BlockManager\Blocks\CounterHeader;

use App\BlockManager\Base\BlockModelInterface;

class CounterHeader implements BlockModelInterface {

    public $title;
    
    public $decription;

    public $weddingDate;

    public $isShowCounter;
    
    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return (string) $this->decription;
    }

    public function getWeddingDate() {
        return $this->weddingDate;
    }

    public function getIsShowCounter() {
        return $this->isShowCounter;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setDescription($decription) {
        $this->decription = $decription;
        return $this;
    }

    public function setWeddingDate($weddingDate) {
        $this->weddingDate = $weddingDate;
        return $this;
    }

    public function setIsShowCounter($isShowCounter) {
        $this->isShowCounter = $isShowCounter;
        return $this;
    }

}