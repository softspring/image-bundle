<?php

namespace Softspring\ImageBundle\EntityListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Softspring\ImageBundle\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\File\File;

class ImageVersionListener
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * ImageVersionListener constructor.
     *
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param ImageVersionInterface     $imageVersion
     * @param PreUpdateEventArgs $eventArgs
     */
    public function preUpdate(ImageVersionInterface $imageVersion, PreUpdateEventArgs $eventArgs)
    {
        $this->storeUpload($imageVersion);
    }

    /**
     * @param ImageVersionInterface     $imageVersion
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(ImageVersionInterface $imageVersion, LifecycleEventArgs $eventArgs)
    {
        $this->storeUpload($imageVersion);
    }

    protected function storeUpload(ImageVersionInterface $imageVersion): void
    {
        $upload = $imageVersion->getUpload();

        if (!$upload instanceof File) {
            return;
        }

        $imageVersion->setFileMimeType($upload->getMimeType());
        $imageVersion->setFileSize($upload->getSize());
        $imageVersion->setUrl($this->storage->store($imageVersion));
        list($width, $height) = getimagesize($upload->getRealPath());
        $imageVersion->setWidth($width);
        $imageVersion->setHeight($height);
    }
}