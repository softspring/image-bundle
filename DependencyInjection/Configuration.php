<?php

namespace Softspring\ImageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
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

                ->arrayNode('types')
                    ->useAttributeAsKey('key')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')->end()
                            ->scalarNode('description')->end()
                            ->append($this->getUploadRequirementsNode())
                            ->append($this->getVersionsNode())
                            ->append($this->getPictureNode())
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    public function getUploadRequirementsNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('upload_requirements');

        /** @var ArrayNodeDefinition $connectionNode */
        $node = method_exists(TreeBuilder::class, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('upload_requirements');

        $node
            ->children()
                ->integerNode('min_width')->defaultValue(0)->end()
                ->integerNode('min_height')->defaultValue(0)->end()
                ->integerNode('max_width')->end()
                ->integerNode('max_height')->end()
                ->arrayNode('allowed_formats')
                    ->enumPrototype()
                        ->values(['jpeg', 'png'])
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    public function getVersionsNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('versions');

        /** @var ArrayNodeDefinition $connectionNode */
        $node = method_exists(TreeBuilder::class, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('versions');

        $node
            ->arrayPrototype()
                ->children()
                    ->append($this->getUploadRequirementsNode())
                    ->integerNode('scale_width')->end()
                    ->integerNode('scale_height')->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    public function getPictureNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('picture');

        /** @var ArrayNodeDefinition $connectionNode */
        $node = method_exists(TreeBuilder::class, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('picture');

        $node
            ->children()
                ->arrayNode('img')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('src_version')->defaultValue('_original')->end()
                    ->end()
                ->end()
                ->arrayNode('sources')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('src_version')->isRequired()->end()
                            ->scalarNode('media')->end()
                            ->scalarNode('sizes')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}