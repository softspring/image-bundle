<?php

namespace Softspring\ImageBundle\Form\Admin;

use Softspring\ImageBundle\Model\ImageTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeDeleteForm extends AbstractType implements TypeDeleteFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageTypeInterface::class,
            'translation_domain' => 'sfs_image',
            'label_format' => 'admin_types.delete.form.%name%.label',
        ]);
    }
}