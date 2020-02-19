<?php

namespace Softspring\ImageBundle\Form\Admin;

use Softspring\CrudlBundle\Form\EntityListFilterForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeListFilterForm extends EntityListFilterForm implements TypeListFilterFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'translation_domain' => 'sfs_image',
            'label_format' => 'admin_types.list.filter_form.%name%.label',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function getOrder(Request $request): array
    {
        return ['key' => 'asc'];
    }
}