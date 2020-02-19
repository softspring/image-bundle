<?php

namespace Softspring\ImageBundle\Storage;

use Softspring\ImageBundle\Model\ImageVersionInterface;

interface StorageInterface
{
    /**
     * @param ImageVersionInterface $version
     *
     * @return string
     */
    public function store(ImageVersionInterface $version): string;
}