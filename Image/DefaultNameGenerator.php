<?php

namespace Softspring\ImageBundle\Image;

use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\HttpFoundation\File\File;

class DefaultNameGenerator implements NameGeneratorInterface
{
    public function generateName(ImageInterface $image, string $version, File $file): string
    {
        if ($version === '_original') {
            $versionName = '';
        } elseif (substr($version, 0, 1) == '_') {
            $versionName = substr($version, 1);
        } else {
            $versionName = $version;
        }

        if ($image->getId()) {
            return $image->getId().'/'.sha1(time().microtime()) . ($versionName?".$versionName" :'') . '.'. $file->guessExtension();
        }

        return sha1(time().$file->getRealPath()). ($versionName?".$versionName" :'') . '.'.$file->guessExtension();
    }
}