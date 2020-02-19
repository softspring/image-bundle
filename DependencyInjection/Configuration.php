<?php

namespace Softspring\ImageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('sfs_image');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('entity_manager')
                    ->defaultValue('default')
                ->end()

                ->arrayNode('type')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue('App\Entity\ImageType')->end()
                        ->scalarNode('find_field_name')->defaultValue('key')->end()
                        ->booleanNode('admin_controller')->defaultFalse()->end()
                    ->end()
                ->end()

                ->arrayNode('image')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue('App\Entity\Image')->end()
                        ->scalarNode('find_field_name')->defaultValue('id')->end()
                        ->booleanNode('admin_controller')->defaultFalse()->end()
                    ->end()
                ->end()

                ->arrayNode('version')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue('App\Entity\ImageVersion')->end()
                        ->scalarNode('find_field_name')->defaultValue('id')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}