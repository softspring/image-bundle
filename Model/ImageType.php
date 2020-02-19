<?php

namespace Softspring\ImageBundle\Model;

/**
 * Class ImageType
 */
abstract class ImageType implements ImageTypeInterface
{
    /**
     * @var string|null
     */
    protected $key;

    /**
     * @var array|null
     */
    protected $definition;

    /**
     * @inheritDoc
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function setKey(?string $key): void
    {
        $this->key = $key;
    }

    /**
     * @inheritDoc
     */
    public function getDefinition(): ?array
    {
        return $this->definition;
    }

    /**
     * @inheritDoc
     */
    public function setDefinition(?array $definition): void
    {
        $this->definition = $definition;
    }
}