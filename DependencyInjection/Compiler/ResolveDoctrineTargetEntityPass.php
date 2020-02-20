<?php

namespace Softspring\ImageBundle\DependencyInjection\Compiler;

use Softspring\CoreBundle\DependencyInjection\Compiler\AbstractResolveDoctrineTargetEntityPass;
use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ResolveDoctrineTargetEntityPass extends AbstractResolveDoctrineTargetEntityPass
{
    /**
     * @inheritDoc
     */
    protected function getEntityManagerName(ContainerBuilder $container): string
    {
        return $container->getParameter('sfs_image.entity_manager_name');
    }

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->setTargetEntityFromParameter('sfs_image.image.class', ImageInterface::class, $container, true);
        $this->setTargetEntityFromParameter('sfs_image.version.class', ImageVersionInterface::class, $container, true);
    }
}