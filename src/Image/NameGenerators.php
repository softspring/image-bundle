<?php

namespace Softspring\ImageBundle\Image;

class NameGenerators
{
    /**
     * @var NameGeneratorInterface[]
     */
    protected array $generators;

    public function __construct(array $generators = [])
    {
        $this->generators = $generators;
    }

    public function getGenerator(string $name): ?NameGeneratorInterface
    {
        return $this->generators[$name];
    }
}
