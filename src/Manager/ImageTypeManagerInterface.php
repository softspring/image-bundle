<?php

namespace Softspring\ImageBundle\Manager;

interface ImageTypeManagerInterface
{
    /**
     * @return array
     */
    public function getTypes(): array;

    /**
     * @param string $type
     *
     * @return array
     */
    public function getType(string $type): array;
}