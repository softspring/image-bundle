<?php

namespace Softspring\ImageBundle\Form\Admin;

use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeUpdateForm extends AbstractTypeForm implements TypeUpdateFormInterface
{
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'translation_domain' => 'sfs_image',
            'label_format' => 'admin_types.update.form.%name%.label',
        ]);
    }
}