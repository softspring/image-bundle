<?php

namespace Softspring\ImageBundle\DependencyInjection;

use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SfsImageExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config/services'));

        // set config parameters
        $container->setParameter('sfs_image.entity_manager_name', $config['entity_manager']);

        // configure model classes
        $container->setParameter('sfs_image.image.class', $config['image']['class']);
        $container->setParameter('sfs_image.image.find_field_name', $config['image']['find_field_name'] ?? null);
        $container->setParameter('sfs_image.version.class', $config['version']['class']);
        $container->setParameter('sfs_image.version.find_field_name', $config['version']['find_field_name'] ?? null);
        $container->setParameter('sfs_image.types', $config['types'] ?? null);

        // load services
        $loader->load('services.yaml');

        if ($config['image']['admin_controller']) {
            $loader->load('controller/admin_images.yaml');
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $doctrineConfig = [];

        // add a default config to force load target_entities, will be overwritten by ResolveDoctrineTargetEntityPass
        $doctrineConfig['orm']['resolve_target_entities'][ImageInterface::class] = 'App\Entity\Image';
        $doctrineConfig['orm']['resolve_target_entities'][ImageVersionInterface::class] = 'App\Entity\ImageVersion';

        // disable auto-mapping for this bundle to prevent mapping errors
        $doctrineConfig['orm']['mappings']['SfsImageBundle'] = [
            'is_bundle' => true,
            'mapping' => false,
        ];

        $container->prependExtensionConfig('doctrine', $doctrineConfig);
    }
}
