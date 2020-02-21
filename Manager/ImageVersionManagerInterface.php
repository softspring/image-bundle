<?php

namespace Softspring\ImageBundle\Manager;

use Softspring\CrudlBundle\Manager\CrudlEntityManagerInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;

interface ImageVersionManagerInterface extends CrudlEntityManagerInterface
{
    /**
     * @param ImageVersionInterface $imageVersion
     */
    public function uploadFile(ImageVersionInterface $imageVersion): void;

    /**
     * @param ImageVersionInterface $imageVersion
     */
    public function removeFile(ImageVersionInterface $imageVersion): void;

    /**
     * @param ImageVersionInterface $imageVersion
     */
    public function fillFieldsFromUploadFile(ImageVersionInterface $imageVersion): void;
}