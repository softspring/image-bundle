<?php

namespace Softspring\ImageBundle\Image;

use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\HttpFoundation\File\File;

interface NameGeneratorInterface
{
    /**
     * @param ImageInterface $image
     * @param string         $version
     * @param File           $file
     *
     * @return string
     */
    public function generateName(ImageInterface $image, string $version, File $file): string;
}