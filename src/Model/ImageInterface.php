<?php

namespace Softspring\ImageBundle\Model;

use Doctrine\Common\Collections\Collection;

interface ImageInterface
{
    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    /**
     * @return Collection|ImageVersionInterface[]
     */
    public function getVersions(): Collection;

    public function addVersion(ImageVersionInterface $version): void;

    public function removeVersion(ImageVersionInterface $version): void;

    public function getVersion(string $version): ?ImageVersionInterface;

    public function checkVersions(array $typeConfig): array;

    public function getUploadedAt(): ?\DateTime;

    public function markUploadedAtNow(): void;
}
