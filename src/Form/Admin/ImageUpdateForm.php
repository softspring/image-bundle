<?php

namespace Softspring\ImageBundle\Form\Admin;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageUpdateForm extends AbstractImageForm implements ImageUpdateFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'translation_domain' => 'sfs_image',
            'label_format' => 'admin_images.update.form.%name%.label',
        ]);
    }
}
