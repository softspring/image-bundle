<?php

namespace Softspring\ImageBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\CrudlBundle\Manager\CrudlEntityManagerTrait;
use Softspring\ImageBundle\Image\NameGenerators;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Softspring\ImageBundle\Storage\StorageDriverInterface;
use Symfony\Component\HttpFoundation\File\File;

class ImageVersionManager implements ImageVersionManagerInterface
{
    use CrudlEntityManagerTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var StorageDriverInterface
     */
    protected $storage;

    /**
     * @var NameGenerators
     */
    protected $nameGenerators;

    /**
     * @var array
     */
    protected $imageTypes;

    /**
     * ImageVersionManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param StorageDriverInterface $storage
     * @param NameGenerators         $nameGenerators
     * @param array                  $imageTypes
     */
    public function __construct(EntityManagerInterface $em, StorageDriverInterface $storage, NameGenerators $nameGenerators, array $imageTypes)
    {
        $this->em = $em;
        $this->storage = $storage;
        $this->nameGenerators = $nameGenerators;
        $this->imageTypes = $imageTypes;
    }

    /**
     * @inheritDoc
     */
    public function getTargetClass(): string
    {
        return ImageVersionInterface::class;
    }

    /**
     * @inheritDoc
     */
    public function uploadFile(ImageVersionInterface $imageVersion): void
    {
        $upload = $imageVersion->getUpload();

        if (!$upload instanceof File) {
            return;
        }

        // fill fields
        $imageVersion->setFileMimeType($upload->getMimeType());
        $imageVersion->setFileSize($upload->getSize());
        [$width, $height] = getimagesize($upload->getRealPath());
        $imageVersion->setWidth($width);
        $imageVersion->setHeight($height);

        // call generator
        $generator = $this->imageTypes[$imageVersion->getImage()->getType()]['generator'];
        $name = $this->nameGenerators->getGenerator($generator)->generateName($imageVersion->getImage(), $imageVersion->getVersion(), $upload);
        // upload file
        $imageVersion->setUrl($this->storage->store($upload, $name));
    }
}