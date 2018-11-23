<?php

namespace App\BlockManager;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class BlockConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('block_manager');
        $rootNode
            ->children()
                ->arrayNode('blocks')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('tag')->end()
                            ->scalarNode('name')->end()
                            ->scalarNode('manager')->end()
                            ->scalarNode('model')->end()
                            ->scalarNode('form')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        // ... add node definitions to the root of the tree

        return $treeBuilder;
    }
}