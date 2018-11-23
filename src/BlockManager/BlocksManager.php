<?php
namespace App\BlockManager;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Processor;
use App\BlockManager\BlockConfiguration;

class BlocksManager {

    private $config;

    private $blockManagerCache = [];

    /**
     * Return array of blocks dedicated for forms
     *
     * @return array
     */
    public function getBlockList() {
        $config = $this->getConfig();
        $blockArray = [];
        foreach($config['blocks'] as $block) {
            $blockArray[$block['name']] = $block['tag'];
        }
        return $blockArray;
    }

    /**
     * Return block manager for structure identified by tag
     *
     * @param string $tag
     * @return object
     */
    public function getManager(string $tag) {
        if(isset($this->blockManagerCache[$tag])) {
            return $this->blockManagerCache[$tag];
        }
        $config = $this->getConfig();
        foreach($config['blocks'] as $block) {
            if($block['tag'] === $tag) {
                $this->blockManagerCache[$tag] = new $block['manager']($block);
                return $this->blockManagerCache[$tag];
            }
        }
        throw new Exception('The block manager \''.$tag.'\' not exists.');
    }

    protected function getConfig() {
        if($this->config === null) {
            $config = Yaml::parse(
                file_get_contents(__DIR__.DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR.'block_manager.yaml')
            );
            
            $processor = new Processor();
            $databaseConfiguration = new BlockConfiguration();
            $processedConfiguration = $processor->processConfiguration(
                $databaseConfiguration,
                $config
            );
            $this->config = $processedConfiguration;
        }
        return $this->config;
    }
}