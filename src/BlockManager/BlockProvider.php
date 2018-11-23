<?php 

namespace App\BlockManager;

use App\BlockManager\Base\BlockModelInterface;
use App\BlockManager\BlocksManager;

class BlockProvider {
    private $blockList = [];
    private $blockTags = [];

    protected $blockPointer = 0;

    protected $blockNextIndex = 0;

    protected $blocksManager;

    public function pushBlock(string $blockTag, BlockModelInterface $blockObj):self {
        $this->blockTags[$this->blockNextIndex] = $blockTag;
        $this->blockList[$this->blockNextIndex] = $blockObj;
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

    public function __construct() {
        $this->blocksManager = new BlocksManager;
    }
}