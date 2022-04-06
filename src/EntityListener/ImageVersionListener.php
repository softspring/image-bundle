<?php

namespace Softspring\ImageBundle\EntityListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use Softspring\ImageBundle\Manager\ImageVersionManagerInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;

class ImageVersionListener
{
    protected ImageVersionManagerInterface $manager;

    public function __construct(ImageVersionManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function preRemove(ImageVersionInterface $imageVersion, LifecycleEventArgs $eventArgs)
    {
        $this->manager->removeFile($imageVersion);
    }
}
