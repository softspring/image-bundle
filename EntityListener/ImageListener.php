<?php

namespace Softspring\ImageBundle\EntityListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Softspring\ImageBundle\Model\ImageInterface;

class ImageListener
{
    /**
     * @param ImageInterface     $image
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(ImageInterface $image, PreUpdateEventArgs $eventArgs)
    {
        foreach ($image->getVersions() as $version) {
            $version->setImage($image);
            $eventArgs->getObjectManager()->persist($version);
        }
    }

    /**
     * @param ImageInterface     $image
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(ImageInterface $image, LifecycleEventArgs $eventArgs)
    {
        foreach ($image->getVersions() as $version) {
            $version->setImage($image);
            $eventArgs->getObjectManager()->persist($version);
        }
    }
}