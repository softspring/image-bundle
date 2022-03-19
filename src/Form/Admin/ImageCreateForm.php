<?php

namespace Softspring\ImageBundle\Form\Admin;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageCreateForm extends AbstractImageForm implements ImageCreateFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'translation_domain' => 'sfs_image',
            'label_format' => 'admin_images.create.form.%name%.label',
        ]);
    }
}
