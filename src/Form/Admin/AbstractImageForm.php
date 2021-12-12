<?php

namespace Softspring\ImageBundle\Form\Admin;

use Softspring\ImageBundle\Form\ImageType;
use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractImageForm extends AbstractType
{
    public function getParent()
    {
        return ImageType::class;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'sfs_image',
        ]);
    }

    public function formOptions(ImageInterface $entity, Request $request): array
    {
        return [
            'image_type' => $entity->getType(),
        ];
    }
}