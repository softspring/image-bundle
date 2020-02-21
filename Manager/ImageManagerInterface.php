<?php

namespace Softspring\ImageBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;

interface ImageManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @param string $type
     *
     * @return ImageInterface
     */
    public function createEntityForType(string $type): ImageInterface;

    /**
     * @param ImageInterface $image
     * @param string         $type
     */
    public function fillEntityForType(ImageInterface $image, string $type): void;

    /**
     * @param ImageInterface $image
     */
    public function processVersionsImages(ImageInterface $image): void;
}