<?php

namespace Softspring\ImageBundle\Manager;

use Softspring\ImageBundle\Type\ImageTypesCollection;

class ImageTypeManager implements ImageTypeManagerInterface
{
    protected ImageTypesCollection $imageTypesCollection;

    public function __construct(ImageTypesCollection $imageTypesCollection)
    {
        $this->imageTypesCollection = $imageTypesCollection;
    }

    public function getTypes(): array
    {
        return $this->imageTypesCollection->getTypes();
    }

    public function getType(string $type): ?array
    {
        return $this->imageTypesCollection->getType($type);
    }
}
