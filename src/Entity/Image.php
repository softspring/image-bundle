<?php

namespace Softspring\ImageBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\DoctrineTemplates\Entity\Traits\UniqId;
use Softspring\ImageBundle\Entity\ImageHasVersionsTrait;
use Softspring\ImageBundle\Model\Image as BaseImage;
use Softspring\ImageBundle\Model\ImageVersionInterface;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ ORM\Cache(region="small_cache", usage="NONSTRICT_READ_WRITE")
 */
class Image extends BaseImage
{
    use UniqId;

    use ImageHasVersionsTrait;

    /**
     * @var Collection|ImageVersionInterface[]
     * @ORM\OneToMany(targetEntity="Softspring\ImageBundle\Model\ImageVersionInterface", mappedBy="image", cascade={"all"}, indexBy="version")
     * @ORM\Cache(region="small_cache", usage="NONSTRICT_READ_WRITE")
     */
    protected $versions;
}