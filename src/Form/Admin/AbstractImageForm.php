<?php

namespace Softspring\ImageBundle\Form\Admin;

use Softspring\ImageBundle\Form\ImageType;
use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractImageForm extends AbstractType
{
    public function getParent(): string
    {
        return ImageType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'sfs_image_admin',
            'label_format' => 'admin_images.form.%name%.label',
        ]);
    }

    public function formOptions(ImageInterface $entity, Request $request): array
    {
        return [
            'image_type' => $entity->getType(),
        ];
    }
}
