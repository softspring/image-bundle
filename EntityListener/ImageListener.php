<?php

namespace Softspring\ImageBundle\EntityListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Softspring\ImageBundle\Manager\ImageVersionManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Symfony\Component\HttpFoundation\File\File;

class ImageListener
{
    /**
     * @var array
     */
    protected $imageTypes;

    /**
     * @var ImageVersionManagerInterface
     */
    protected $versionManager;

    /**
     * ImageListener constructor.
     *
     * @param array                        $imageTypes
     * @param ImageVersionManagerInterface $versionManager
     */
    public function __construct(array $imageTypes, ImageVersionManagerInterface $versionManager)
    {
        $this->imageTypes = $imageTypes;
        $this->versionManager = $versionManager;
    }

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

        $originalVersion = $image->getVersion('_original');

        foreach ($this->imageTypes[$image->getType()]['versions'] as $key => $config) {
            if (isset($config['upload_requirements'])) {
                continue;
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

            $tmpPath = tempnam(sys_get_temp_dir(), 'sfs_image_') . '.jpeg';

            $imagine = new Imagine();
            $gdImage = $imagine->open($originalVersion->getUpload()->getRealPath());
            $gdImage->resize(new Box($scaleWidth, $scaleHeight));
            $gdImage->save($tmpPath);

            /** @var ImageVersionInterface $newVersion */
            $newVersion = $this->versionManager->createEntity();
            $newVersion->setImage($image);
            $newVersion->setVersion($key);
            $newVersion->setUpload(new File($tmpPath));
            $eventArgs->getObjectManager()->persist($newVersion);
        }
    }
}