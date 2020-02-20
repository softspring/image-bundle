<?php

namespace Softspring\ImageBundle\EntityListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Softspring\ImageBundle\Manager\ImageVersionManagerInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;

class ImageVersionListener
{
    /**
     * @var ImageVersionManagerInterface
     */
    protected $manager;

    /**
     * ImageVersionListener constructor.
     *
     * @param ImageVersionManagerInterface $manager
     */
    public function __construct(ImageVersionManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param ImageVersionInterface     $imageVersion
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(ImageVersionInterface $imageVersion, PreUpdateEventArgs $eventArgs)
    {
        $this->manager->uploadFile($imageVersion);
    }

    /**
     * @param ImageVersionInterface     $imageVersion
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(ImageVersionInterface $imageVersion, LifecycleEventArgs $eventArgs)
    {
        $this->manager->uploadFile($imageVersion);
    }
}