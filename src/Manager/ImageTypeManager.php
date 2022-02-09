<?php

namespace Softspring\ImageBundle\Manager;

class ImageTypeManager implements ImageTypeManagerInterface
{
    /**
     * @var array
     */
    protected $imageTypes;

    /**
     * ImageTypeManager constructor.
     */
    public function __construct(array $imageTypes)
    {
        $this->imageTypes = $imageTypes;
    }

    /**
     * {@inheritDoc}
     */
    public function getTypes(): array
    {
        return $this->imageTypes;
    }

    /**
     * {@inheritDoc}
     */
    public function getType(string $type): array
    {
        return $this->imageTypes[$type];
    }
}
