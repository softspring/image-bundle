<?php

namespace Softspring\ImageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeDefinitionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'sfs_image',
            'label_format' => 'type_definition_type.%name%.label'
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder->add('width', IntegerType::class);
//        $builder->add('height', IntegerType::class);

        $builder->add('_original', TypeRequirementsType::class, [
            'label' => 'type_definition_type._original.label',
        ]);

        $builder->add('versions', CollectionType::class, [
            'entry_type' => TypeDefinitionSourceType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'block_prefix' => 'type_definition_version_collection',
        ]);
    }
}