<?php

namespace Softspring\ImageBundle\Model;

use Doctrine\Common\Collections\Collection;

interface ImageInterface
{
    /**
     * @return mixed
     */
    public function getId();

    public function getType(): ?string;

    public function setType(?string $type): void;

    /**
     * @return Collection|ImageVersionInterface[]
     */
    public function getVersions();

    public function addVersion(ImageVersionInterface $version): void;

    public function removeVersion(ImageVersionInterface $version): void;

    public function getVersion(string $version): ?ImageVersionInterface;

    public function getUploadedAt(): ?\DateTime;

    public function markUploadedAtNow(): void;
}
