<?php

namespace Softspring\ImageBundle\Manager;

use Softspring\Component\CrudlController\Manager\CrudlEntityManagerInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;

interface ImageVersionManagerInterface extends CrudlEntityManagerInterface
{
    public function uploadFile(ImageVersionInterface $imageVersion): void;

    public function removeFile(ImageVersionInterface $imageVersion): void;

    public function downloadFile(ImageVersionInterface $imageVersion): string;

    public function fillFieldsFromUploadFile(ImageVersionInterface $imageVersion): void;

    /**
     * @return ImageVersionInterface
     */
    public function createEntity(): object;

    /**
     * @param ImageVersionInterface $entity
     */
    public function saveEntity(object $entity): void;

    /**
     * @param ImageVersionInterface $entity
     */
    public function deleteEntity(object $entity): void;
}
