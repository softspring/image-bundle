<?php

namespace Softspring\ImageBundle\DependencyInjection\Compiler;

use Softspring\ImageBundle\Type\ImageTypesCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ImageTypeProvidersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $imageTypesCollection = $container->getDefinition(ImageTypesCollection::class);

        $taggedServices = $container->findTaggedServiceIds('sfs_image.image_type_provider');
        $providers = [];
        foreach ($taggedServices as $id => $tags) {
            $providers[$id] = new Reference($id);
        }

        $imageTypesCollection->setArgument(0, $providers);
    }
}
