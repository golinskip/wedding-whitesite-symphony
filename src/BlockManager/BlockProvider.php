<?php 

namespace App\BlockManager;

use App\BlockManager\Base\BlockModelInterface;
use App\BlockManager\BlocksManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class BlockProvider {
    private $blockList = [];

    private $blockTags = [];

    private $blockTwigParams = [];

    protected $blockPointer = 0;

    protected $blockNextIndex = 0;

    protected $blocksManager;

    private $container;

    private $attr;

    public function pushBlock(string $blockTag, BlockModelInterface $blockObj):self {
        $this->blockTags[$this->blockNextIndex] = $blockTag;
        $this->blockList[$this->blockNextIndex] = $blockObj;
        $this->blockTwigParams[$this->blockNextIndex] = 
            $this->blocksManager->getManager($blockTag)->getTwigParams(
                $blockObj, $this->container, $this->attr
            );
        $this->blockNextIndex++;
        return $this;
    }

    public function popBlock():?BlockModelInterface {
        if($this->blockNextIndex === $this->blockPointer) {
            return null;
        }
        $pointerIdx = $this->blockPointer;
        $this->blockPointer++;
        return $this->blockList[$pointerIdx];
    }

    public function getCurrentObj() {
        if($this->isEnd()) {
            return null;
        }
        return $this->blockList[$this->blockPointer];
    }

    public function getCurrentTypeManager() {
        if($this->isEnd()) {
            return null;
        }
        $currentTag = $this->blockTags[$this->blockPointer];
        return $this->blocksManager->getManager($currentTag);
    }

    public function getCurrentTag() {
        if($this->isEnd()) {
            return null;
        }
        return $this->blockTags[$this->blockPointer];
    }

    public function getCurrentTwigParams() {
        if($this->isEnd()) {
            return null;
        }
        return $this->blockTwigParams[$this->blockPointer];
    }

    public function isEnd() {
        return($this->blockPointer === $this->blockNextIndex);
    }

    public function getCount() {
        return $this->blockNextIndex;
    }

    public function revind():self {
        $this->blockPointer = 0;
        return $this;
    }

    public function getObjNext() {
        return $this->popBlock();
    }

    public function getGoNext() {
        $this->popBlock();
        return "";
    }

    public function setAttr($attr) {
        $this->attr = $attr;
    }

    public function __construct(Container $container) {
        $this->container = $container;
        $this->blocksManager = new BlocksManager;
    }
}