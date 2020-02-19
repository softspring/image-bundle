<?php

namespace Softspring\ImageBundle\Model;

/**
 * Interface ImageTypeInterface
 */
interface ImageTypeInterface
{
    /**
     * @return string|null
     */
    public function getKey(): ?string;

    /**
     * @param string|null $key
     */
    public function setKey(?string $key): void;

    /**
     * @return array|null
     */
    public function getDefinition(): ?array;

    /**
     * @param array|null $definition
     */
    public function setDefinition(?array $definition): void;
}