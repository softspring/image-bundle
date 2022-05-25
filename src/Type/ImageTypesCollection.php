<?php

namespace Softspring\ImageBundle\Type;

class ImageTypesCollection
{
    protected array $types = [];

    /**
     * @param ImageTypeProviderInterface[] $providers
     */
    public function __construct(array $providers)
    {
        foreach ($providers as $provider) {
            $this->types += $provider->getTypes();
        }
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function getType(string $type): ?array
    {
        return $this->types[$type] ?? null;
    }
}