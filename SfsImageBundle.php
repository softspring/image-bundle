<?php

namespace Softspring\ImageBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Softspring\ImageBundle\DependencyInjection\Compiler\AliasDoctrineEntityManagerPass;
use Softspring\ImageBundle\DependencyInjection\Compiler\NameGeneratorsPass;
use Softspring\ImageBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntityPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SfsImageBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $basePath = realpath(__DIR__.'/Resources/config/doctrine-mapping/');

        $this->addRegisterMappingsPass($container, [$basePath => 'Softspring\ImageBundle\Model']);

        $container->addCompilerPass(new AliasDoctrineEntityManagerPass());
        $container->addCompilerPass(new NameGeneratorsPass());
        $container->addCompilerPass(new ResolveDoctrineTargetEntityPass());
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $mappings
     * @param string|bool      $enablingParameter
     */
    private function addRegisterMappingsPass(ContainerBuilder $container, array $mappings, $enablingParameter = false)
    {
        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, ['sfs_image.entity_manager_name'], $enablingParameter));
    }
}