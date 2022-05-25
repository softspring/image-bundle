<?php

namespace Softspring\ImageBundle\Type;

interface ImageTypeProviderInterface
{
    public function getTypes(): array;
}