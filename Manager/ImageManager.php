<?php

namespace Softspring\ImageBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\CrudlBundle\Manager\CrudlEntityManagerTrait;
use Softspring\ImageBundle\Model\ImageInterface;

class ImageManager implements ImageManagerInterface
{
    use CrudlEntityManagerTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * ImageManager constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getTargetClass(): string
    {
        return ImageInterface::class;
    }
}