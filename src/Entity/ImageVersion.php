<?php

namespace Softspring\ImageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\DoctrineTemplates\Entity\Traits\UniqId;
use Softspring\ImageBundle\Model\ImageVersion as BaseImageVersion;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks 
 * @ ORM\Cache(region="small_cache", usage="NONSTRICT_READ_WRITE")
 */
class ImageVersion extends BaseImageVersion
{
    use UniqId;
}