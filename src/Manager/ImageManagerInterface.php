<?php

namespace Softspring\ImageBundle\Manager;

use Softspring\Component\CrudlController\Manager\CrudlEntityManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;

interface ImageManagerInterface extends CrudlEntityManagerInterface
{
    public function createEntityForType(string $type): ImageInterface;

    public function fillEntityForType(ImageInterface $image, string $type): void;

    public function processVersionsImages(ImageInterface $image): void;

    /**
     * @return ImageInterface
     */
    public function createEntity();

    /**
     * @param ImageInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param ImageInterface $entity
     */
    public function deleteEntity($entity): void;
}
