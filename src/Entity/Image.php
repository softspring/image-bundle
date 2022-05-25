<?php

namespace Softspring\ImageBundle\Entity;

use Softspring\ImageBundle\Model\Image as ImageModel;

class Image extends ImageModel
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
