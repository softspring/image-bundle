<?php

namespace Softspring\ImageBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\Component\CrudlController\Manager\CrudlEntityManagerTrait;
use Softspring\ImageBundle\Image\NameGenerators;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Softspring\ImageBundle\Storage\StorageDriverInterface;
use Softspring\ImageBundle\Type\ImageTypesCollection;
use Symfony\Component\HttpFoundation\File\File;

class ImageVersionManager implements ImageVersionManagerInterface
{
    use CrudlEntityManagerTrait;

    protected EntityManagerInterface $em;

    protected StorageDriverInterface $storage;

    protected NameGenerators $nameGenerators;

    protected ImageTypesCollection $imageTypesCollection;

    public function __construct(EntityManagerInterface $em, StorageDriverInterface $storage, NameGenerators $nameGenerators, ImageTypesCollection $imageTypesCollection)
    {
        $this->em = $em;
        $this->storage = $storage;
        $this->nameGenerators = $nameGenerators;
        $this->imageTypesCollection = $imageTypesCollection;
    }

    public function getTargetClass(): string
    {
        return ImageVersionInterface::class;
    }

    public function uploadFile(ImageVersionInterface $imageVersion): void
    {
        $upload = $imageVersion->getUpload();

        if (!$upload instanceof File) {
            return;
        }

        // call generator
        $generator = $this->imageTypesCollection->getType($imageVersion->getImage()->getType())['generator'];
        $name = $this->nameGenerators->getGenerator($generator)->generateName($imageVersion->getImage(), $imageVersion->getVersion(), $upload);
        // upload file
        $imageVersion->setUrl($this->storage->store($upload, $name));
    }

    public function removeFile(ImageVersionInterface $imageVersion): void
    {
        $this->storage->remove($imageVersion->getUrl());
    }

    public function downloadFile(ImageVersionInterface $imageVersion): string
    {
        $tempName = tempnam(sys_get_temp_dir(), 'sfs_image');
        $this->storage->download($imageVersion->getUrl(), $tempName);

        return $tempName;
    }

    public function fillFieldsFromUploadFile(ImageVersionInterface $imageVersion): void
    {
        if (!$upload = $imageVersion->getUpload()) {
            return;
        }

        $imageVersion->setFileMimeType($upload->getMimeType());
        $imageVersion->setFileSize($upload->getSize());
        [$width, $height] = getimagesize($upload->getRealPath());
        $imageVersion->setWidth($width);
        $imageVersion->setHeight($height);
    }
}
