<?php

namespace Softspring\ImageBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Softspring\ImageBundle\Manager\ImageTypeManagerInterface;
use Softspring\ImageBundle\Model\ImageTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class ImageTypeParamConverter implements ParamConverterInterface
{
    /**
     * @var ImageTypeManagerInterface
     */
    protected $manager;

    /**
     * ImageTypeParamConverter constructor.
     *
     * @param ImageTypeManagerInterface $manager
     */
    public function __construct(ImageTypeManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $query = $request->attributes->get($configuration->getName());
        $entity = $this->manager->getRepository()->findOneBy(['key' => $query]);
        $request->attributes->set($configuration->getName(), $entity);
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === ImageTypeInterface::class;
    }
}