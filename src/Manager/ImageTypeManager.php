<?php

namespace Softspring\ImageBundle\Manager;

class ImageTypeManager implements ImageTypeManagerInterface
{
    protected array $imageTypes;

    public function __construct(array $imageTypes)
    {
        $this->imageTypes = $imageTypes;
    }

    public function getTypes(): array
    {
        return $this->imageTypes;
    }

    public function getType(string $type): array
    {
        return $this->imageTypes[$type];
    }
}
