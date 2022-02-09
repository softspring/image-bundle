<?php

namespace Softspring\ImageBundle\Manager;

interface ImageTypeManagerInterface
{
    public function getTypes(): array;

    public function getType(string $type): array;
}
