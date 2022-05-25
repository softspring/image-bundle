<?php

namespace Softspring\ImageBundle\Type;

class ConfigImageTypeProvider implements ImageTypeProviderInterface
{
    protected array $imageTypesConfig;

    public function __construct(array $imageTypesConfig)
    {
        $this->imageTypesConfig = $imageTypesConfig;
    }

    public function getTypes(): array
    {
        return $this->imageTypesConfig;
    }
}