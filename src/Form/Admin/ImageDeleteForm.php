<?php

namespace Softspring\ImageBundle\Form\Admin;

use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageDeleteForm extends AbstractType implements ImageDeleteFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageInterface::class,
            'translation_domain' => 'sfs_image',
            'label_format' => 'admin_images.delete.form.%name%.label',
        ]);
    }
}
