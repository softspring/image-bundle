<?php

namespace Softspring\ImageBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class Image implements ImageInterface
{
    protected ?string $type = null;

    protected ?string $name = null;

    protected ?string $description = null;

    /**
     * @var ImageVersion[]|Collection|null
     */
    protected ?Collection $versions;

    protected ?int $uploadedAt = null;

    public function __construct()
    {
        $this->versions = new ArrayCollection();
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getUploadedAt(): ?\DateTime
    {
        return $this->uploadedAt ? \DateTime::createFromFormat('U', $this->uploadedAt) : null;
    }

    public function markUploadedAtNow(): void
    {
        $this->uploadedAt = gmdate('U');
    }

    public function getVersions(): Collection
    {
        return $this->versions;
    }

    public function addVersion(ImageVersionInterface $version): void
    {
        if (empty($this->versions[$version->getVersion()])) {
            $this->versions[$version->getVersion()] = $version;
            $version->setImage($this);
            $this->markUploadedAtNow();
        }
    }

    public function removeVersion(ImageVersionInterface $version): void
    {
        if (!empty($this->versions[$version->getVersion()])) {
            unset($this->versions[$version->getVersion()]);
            $this->markUploadedAtNow();
        }
    }

    public function getVersion(string $version): ?ImageVersionInterface
    {
        return $this->versions->filter(function (ImageVersionInterface $imageVersion) use ($version) {
            return $imageVersion->getVersion() == $version;
        })->first() ?: null;
    }
}
