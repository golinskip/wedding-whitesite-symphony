<?php
namespace App\BlockManager\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Processor;
use App\BlockManager\BlockConfiguration;

class BlockManager {
    private $container;

    private $config;
    

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function getBlockList() {
        $config = $this->getConfig();
        $blockArray = [];
        foreach($config['blocks'] as $block) {
            $blockArray[$block['name']] = $block['tag'];
        }
        return $blockArray;
    }

    protected function getConfig() {
        if($this->config === null) {
            $config = Yaml::parse(
                file_get_contents(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR.'block_manager.yaml')
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