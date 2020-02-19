<?php

namespace Softspring\ImageBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\CrudlBundle\Manager\CrudlEntityManagerTrait;
use Softspring\ImageBundle\Model\ImageTypeInterface;

class ImageTypeManager implements ImageTypeManagerInterface
{
    use CrudlEntityManagerTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * ImageTypeManager constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getTargetClass(): string
    {
        return ImageTypeInterface::class;
    }

    public function createEntity()
    {
        $class = $this->getEntityClass();
        /** @var ImageTypeInterface $entity */
        $entity = new $class;

        $entity->getDefinition()['_thumbnails'] = [];

        return $entity;
    }
}