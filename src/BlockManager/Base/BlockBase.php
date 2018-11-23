<?php

namespace App\BlockManager\Base;

use App\BlockManager\Base\BlockInterface;

abstract class BlockBase implements BlockInterface
{
    protected $config;

    public function createObject() {
        $className = $this->config['model'];
        $newObject = new $className;
        return $newObject;
    }

    public function getFormClass() {
        $className = $this->config['form'];
        return $className;
    }

    protected function getConfig() {
        return $this->config;
    }

    public function __construct($config) {
        $this->config = $config;
    }
}