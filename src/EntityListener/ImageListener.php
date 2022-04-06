<?php

namespace Softspring\ImageBundle\EntityListener;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Softspring\ImageBundle\Manager\ImageManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;

class ImageListener
{
    protected ImageManagerInterface $imageManager;

    public function __construct(ImageManagerInterface $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function preFlush(ImageInterface $image, PreFlushEventArgs $eventArgs)
    {
        $this->imageManager->processVersionsImages($image);
    }
}
