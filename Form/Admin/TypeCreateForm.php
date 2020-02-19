<?php

namespace Softspring\ImageBundle\Form\Admin;

use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeCreateForm extends AbstractTypeForm implements TypeCreateFormInterface
{
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'translation_domain' => 'sfs_image',
            'label_format' => 'admin_types.create.form.%name%.label',
        ]);
    }
}