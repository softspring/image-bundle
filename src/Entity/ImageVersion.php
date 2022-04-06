<?php

namespace Softspring\ImageBundle\Entity;

use Softspring\ImageBundle\Model\ImageVersion as ImageVersionModel;

class ImageVersion extends ImageVersionModel
{
    protected ?string $id = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return ''.$this->getId();
    }
}