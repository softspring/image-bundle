<?php

namespace Softspring\ImageBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Softspring\Component\CrudlController\Manager\CrudlEntityManagerTrait;
use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Symfony\Component\HttpFoundation\File\File;

class ImageManager implements ImageManagerInterface
{
    use CrudlEntityManagerTrait;

    protected EntityManagerInterface $em;

    protected ImageTypeManagerInterface $imageTypeManager;

    protected ImageVersionManagerInterface $imageVersionManager;

    public function __construct(EntityManagerInterface $em, ImageTypeManagerInterface $imageTypeManager, ImageVersionManagerInterface $imageVersionManager)
    {
        $this->em = $em;
        $this->imageTypeManager = $imageTypeManager;
        $this->imageVersionManager = $imageVersionManager;
    }

    public function getTargetClass(): string
    {
        return ImageInterface::class;
    }

    public function createEntityForType(string $type): ImageInterface
    {
        /** @var ImageInterface $image */
        $image = $this->createEntity();

        $this->fillEntityForType($image, $type);

        return $image;
    }

    public function fillEntityForType(ImageInterface $image, string $type): void
    {
        $typeDefinition = $this->imageTypeManager->getType($type);

        $image->setType($type);

        $version = $this->imageVersionManager->createEntity();
        $version->setVersion('_original');
        $image->addVersion($version);

        foreach ($typeDefinition['versions'] as $key => $config) {
            $version = $this->imageVersionManager->createEntity();
            $version->setVersion($key);
            $image->addVersion($version);
        }
    }

    public function processVersionsImages(ImageInterface $image): void
    {
        // persist versions
        foreach ($image->getVersions() as $version) {
            $version->setImage($image);
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
        }
    }

    public function generateVersion(ImageInterface $image, string $version): void
    {
        $versionConfig = $this->imageTypeManager->getTypes()[$image->getType()]['versions'][$version];

        $originalVersion = $image->getVersion('_original');

        $originalVersion->setUpload(new File($this->imageVersionManager->downloadFile($originalVersion)));

        $imageVersion = $this->getAndScaleImageVersion($image, $version, $versionConfig, $image->getVersion('_original'));
        $this->updateStorage($imageVersion);

        $originalVersion->setUpload(null);

        $this->imageVersionManager->saveEntity($imageVersion);
    }

    public function deleteVersion(ImageVersionInterface $version): void
    {
        $image = $version->getImage();
        $image->removeVersion($version);
        $this->imageVersionManager->deleteEntity($version);
        $this->saveEntity($image);
    }

    /**
     * @throws \Exception
     */
    protected function getAndScaleImageVersion(ImageInterface $image, string $key, array $config, ImageVersionInterface $originalVersion): ImageVersionInterface
    {
        /** @var ImageVersionInterface $imageVersion */
        $imageVersion = $image->getVersion($key);
        if (!$imageVersion) {
            $imageVersion = $this->imageVersionManager->createEntity();
            $image->addVersion($imageVersion);
            $imageVersion->setVersion($key);
        }

        $scaleWidth = $config['scale_width'] ?? null;
        $scaleHeight = $config['scale_height'] ?? null;
        if (null === $scaleWidth && null === $scaleHeight) {
            throw new \Exception('You should configure scale_width or scale_height');
        } elseif (null !== $scaleWidth && null === $scaleHeight) {
            $scaleHeight = $scaleWidth * $originalVersion->getHeight() / $originalVersion->getWidth();
        } elseif (null === $scaleWidth && null !== $scaleHeight) {
            $scaleWidth = $scaleHeight * $originalVersion->getWidth() / $originalVersion->getHeight();
        }

        $extension = $type = $config['type'];

        $tmpPath = tempnam(sys_get_temp_dir(), 'sfs_image_').'.'.$extension;

        $imagine = new Imagine();
        $gdImage = $imagine->open($originalVersion->getUpload()->getRealPath());
        $gdImage->resize(new Box($scaleWidth, $scaleHeight));

        // https://imagine.readthedocs.io/en/stable/usage/introduction.html#save-images
        $validOptions = array_flip(['png_compression_level', 'webp_quality', 'flatten', 'jpeg_quality', 'resolution-units', 'resolution-x', 'resolution-y', 'resampling-filter']);
        $saveOptions = array_intersect_key($config, $validOptions);
        $gdImage->save($tmpPath, $saveOptions);

        // save options in database
        $databaseOptions = $config;
        unset($databaseOptions['upload_requirements']);
        $imageVersion->setOptions($databaseOptions);

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
