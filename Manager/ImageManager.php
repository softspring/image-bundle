<?php

namespace Softspring\ImageBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Softspring\CrudlBundle\Manager\CrudlEntityManagerTrait;
use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Symfony\Component\HttpFoundation\File\File;

class ImageManager implements ImageManagerInterface
{
    use CrudlEntityManagerTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var ImageTypeManagerInterface
     */
    protected $imageTypeManager;

    /**
     * @var ImageVersionManagerInterface
     */
    protected $imageVersionManager;

    /**
     * ImageManager constructor.
     *
     * @param EntityManagerInterface       $em
     * @param ImageTypeManagerInterface    $imageTypeManager
     * @param ImageVersionManagerInterface $imageVersionManager
     */
    public function __construct(EntityManagerInterface $em, ImageTypeManagerInterface $imageTypeManager, ImageVersionManagerInterface $imageVersionManager)
    {
        $this->em = $em;
        $this->imageTypeManager = $imageTypeManager;
        $this->imageVersionManager = $imageVersionManager;
    }

    /**
     * @inheritDoc
     */
    public function getTargetClass(): string
    {
        return ImageInterface::class;
    }

    /**
     * @inheritDoc
     */
    public function createEntityForType(string $type): ImageInterface
    {
        /** @var ImageInterface $image */
        $image = $this->createEntity();

        $this->fillEntityForType($image, $type);

        return $image;
    }

    /**
     * @inheritDoc
     */
    public function fillEntityForType(ImageInterface $image, string $type): void
    {
        $typeDefinition = $this->imageTypeManager->getType($type);

        $image->setType($type);

        /** @var ImageVersionInterface $version */
        $version = $this->imageVersionManager->createEntity();
        $version->setVersion('_original');
        $image->addVersion($version);

        foreach ($typeDefinition['versions'] as $key => $config) {
            /** @var ImageVersionInterface $version */
            $version = $this->imageVersionManager->createEntity();
            $version->setVersion($key);
            $image->addVersion($version);
        }
    }

    /**
     * @inheritDoc
     */
    public function processVersionsImages(ImageInterface $image): void
    {
        // persist versions
        foreach ($image->getVersions() as $version) {
            $version->setImage($image);
            $this->em->persist($version);
        }

        // process original
        $originalVersion = $image->getVersion('_original');

        if (!$originalVersion || !$originalVersion->getUpload()) {
            return;
        }

        $this->imageVersionManager->fillFieldsFromUploadFile($originalVersion);
        $this->updateStorage($originalVersion);

        // process other versions
        foreach ($this->imageTypeManager->getTypes()[$image->getType()]['versions'] as $key => $config) {
            if (isset($config['upload_requirements'])) {
                continue;
            }

            $imageVersion = $this->getAndScaleImageVersion($image, $key, $config, $originalVersion);
            $this->updateStorage($imageVersion);
            $this->em->persist($imageVersion);
        }
    }

    /**
     * @param ImageInterface        $image
     * @param string                $key
     * @param array                 $config
     * @param ImageVersionInterface $originalVersion
     *
     * @return ImageVersionInterface
     * @throws \Exception
     */
    protected function getAndScaleImageVersion(ImageInterface $image, string $key, array $config, ImageVersionInterface $originalVersion): ImageVersionInterface
    {
        /** @var ImageVersionInterface $imageVersion */
        $imageVersion = $image->getVersion($key);
        if (!$imageVersion) {
            $imageVersion = $this->imageVersionManager->createEntity();
            $imageVersion->setImage($image);
            $imageVersion->setVersion($key);
        }

        $scaleWidth = $config['scale_width'] ?? null;
        $scaleHeight = $config['scale_height'] ?? null;
        if ($scaleWidth === null && $scaleHeight === null) {
            throw new \Exception('You should configure scale_width or scale_height');
        } elseif ($scaleWidth !== null && $scaleHeight === null) {
            $scaleHeight = $scaleWidth * $originalVersion->getHeight() / $originalVersion->getWidth();
        } elseif ($scaleWidth === null && $scaleHeight !== null) {
            $scaleWidth = $scaleHeight * $originalVersion->getWidth() / $originalVersion->getHeight();
        }

        $extension = $type = $config['type'];

        $tmpPath = tempnam(sys_get_temp_dir(), 'sfs_image_') . '.' . $extension;

        $imagine = new Imagine();
        $gdImage = $imagine->open($originalVersion->getUpload()->getRealPath());
        $gdImage->resize(new Box($scaleWidth, $scaleHeight));
        $gdImage->save($tmpPath);

        $imageVersion->setUpload(new File($tmpPath));

        $this->imageVersionManager->fillFieldsFromUploadFile($imageVersion);

        $imageVersion->setImage($image);

        return $imageVersion;
    }

    protected function updateStorage(ImageVersionInterface $imageVersion): void
    {
        if ($imageVersion->getUrl() && $imageVersion->getUpload()) {
            $this->imageVersionManager->removeFile($imageVersion);
        }

        $this->imageVersionManager->uploadFile($imageVersion);
    }
}