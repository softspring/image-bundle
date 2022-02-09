<?php

namespace Softspring\ImageBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;

interface ImageVersionManagerInterface extends CrudlEntityManagerInterface
{
    public function uploadFile(ImageVersionInterface $imageVersion): void;

    public function removeFile(ImageVersionInterface $imageVersion): void;

    public function fillFieldsFromUploadFile(ImageVersionInterface $imageVersion): void;

    /**
     * @return ImageVersionInterface
     */
    public function createEntity();

    /**
     * @param ImageVersionInterface $entity
     */
    public function saveEntity($entity): void;

    /**
     * @param ImageVersionInterface $entity
     */
    public function deleteEntity($entity): void;
}
