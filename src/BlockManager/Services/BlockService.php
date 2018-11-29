<?php
namespace App\BlockManager\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use App\BlockManager\BlocksManager;
use App\BlockManager\BlockProvider;

class BlockService extends BlocksManager {

    private $attr;

    private $container;

    private $blockProvider;

    public function __construct(Container $container) {
        $this->container = $container;
        $this->attr = [];
        $this->blockProvider = new BlockProvider($container);
    }

    public function setAttr($name, $value) {
        $this->attr[$name] = $value;
        $this->blockProvider->setAttr($this->attr);
    }

    public function getAttr($name) {
        if(isset($this->attr[$name])) {
            return $this->attr[$name];
        }
        return null;
    }

    public function getBlockProvider() {
        return $this->blockProvider;
    }
}