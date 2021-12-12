<?php

namespace Softspring\ImageBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class Image implements ImageInterface
{
    /**
     * @var string|null
     */
    protected $type;

    /**
     * @var ImageVersion[]|Collection
     */
    protected $versions;

    /**
     * @var int|null
     */
    protected $uploadedAt;

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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function getUploadedAt(): ?\DateTime
    {
        return $this->uploadedAt ? \DateTime::createFromFormat("U", $this->uploadedAt) : null;
    }

    /**
     * @inheritDoc
     */
    public function markUploadedAtNow(): void
    {
        $this->uploadedAt = gmdate('U');
    }
}