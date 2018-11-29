<?php

namespace App\BlockManager\Base;

use App\BlockManager\Base\BlockInterface;
use App\BlockManager\Base\BlockModelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

abstract class BlockBase implements BlockInterface
{
    protected $config;

    protected $params;

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

    public function getTwigParams(BlockModelInterface $model, Container $container, $attr) {
        return $attr;
    }

    abstract public function getTwigTemplate();
}