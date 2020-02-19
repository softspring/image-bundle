<?php

namespace Softspring\ImageBundle\Model;

use Doctrine\Common\Collections\Collection;

interface ImageInterface
{
    /**
     * @return ImageTypeInterface|null
     */
    public function getType(): ?ImageTypeInterface;

    /**
     * @param ImageTypeInterface|null $type
     */
    public function setType(?ImageTypeInterface $type): void;

    /**
     * @return Collection|ImageVersionInterface[]
     */
    public function getVersions();

    /**
     * @param ImageVersionInterface $version
     */
    public function addVersion(ImageVersionInterface $version): void;

    /**
     * @param ImageVersionInterface $version
     */
    public function removeVersion(ImageVersionInterface $version): void;

    /**
     * @param string $version
     *
     * @return ImageVersionInterface|null
     */
    public function getVersion(string $version): ?ImageVersionInterface;
}