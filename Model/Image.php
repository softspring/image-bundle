<?php

namespace Softspring\ImageBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class Image implements ImageInterface
{
    /**
     * @var ImageTypeInterface|null
     */
    protected $type;

    /**
     * @var ImageVersion[]|Collection
     */
    protected $versions;

    /**
     * Image constructor.
     */
    public function __construct()
    {
        $this->versions = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function getType(): ?ImageTypeInterface
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function setType(?ImageTypeInterface $type): void
    {
        $this->type = $type;
    }
}