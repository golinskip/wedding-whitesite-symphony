<?php

namespace App\Services;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class ConfigConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('config');
        $rootNode
            ->children()
                ->arrayNode('vars')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('type')
                                ->isRequired()
                                ->end()
                            ->scalarNode('form_type')
                                ->isRequired()
                                ->end()
                            ->variableNode('form_options')->end()
                            ->scalarNode('group')
                                ->isRequired()
                                ->end()
                            ->scalarNode('label')->end()
                            ->scalarNode('default')->end()
                            ->scalarNode('show')
                                ->isRequired()
                                ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        // ... add node definitions to the root of the tree

        return $treeBuilder;
    }
}