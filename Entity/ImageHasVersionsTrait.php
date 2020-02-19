<?php

namespace Softspring\ImageBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\ImageBundle\Model\ImageVersionInterface;

trait ImageHasVersionsTrait
{
    /**
     * @var Collection|ImageVersionInterface[]
     * @ORM\OneToMany(targetEntity="Softspring\ImageBundle\Model\ImageVersionInterface", mappedBy="image", cascade={"all"}, indexBy="version")
     */
    protected $versions;

    /**
     * @inheritDoc
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * @inheritDoc
     */
    public function addVersion(ImageVersionInterface $version): void
    {
        if (empty($this->versions[$version->getVersion()])) {
            $this->versions[$version->getVersion()] = $version;
            $version->setImage($this);
        }
    }

    /**
     * @inheritDoc
     */
    public function removeVersion(ImageVersionInterface $version): void
    {
        if (!empty($this->versions[$version->getVersion()])) {
            unset($this->versions[$version->getVersion()]);
        }
    }

    /**
     * @inheritDoc
     */
    public function getVersion(string $version): ?ImageVersionInterface
    {
        return $this->versions->filter(function(ImageVersionInterface $imageVersion) use ($version) {
            return $imageVersion->getVersion() == $version;
        })->first();
    }
}