<?php

namespace Softspring\ImageBundle\EntityListener;

use Doctrine\ORM\Event\PreFlushEventArgs;
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
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(ImageVersionInterface $imageVersion, LifecycleEventArgs $eventArgs)
    {
        $this->manager->removeFile($imageVersion);
    }
}