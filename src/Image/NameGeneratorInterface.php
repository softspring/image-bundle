<?php

namespace Softspring\ImageBundle\Image;

use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\HttpFoundation\File\File;

interface NameGeneratorInterface
{
    public function generateName(ImageInterface $image, string $version, File $file): string;
}
