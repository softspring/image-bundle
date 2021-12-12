<?php

namespace Softspring\ImageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;

class TypeRequirementsType extends AbstractType
{
    public function getBlockPrefix()
    {
        return 'type_requirements';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label_format' => 'type_requirements_type.%name%.label'
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('minWidth', IntegerType::class);

        $builder->add('minHeight', IntegerType::class);

        $builder->add('maxWidth', IntegerType::class);

        $builder->add('maxHeight', IntegerType::class);

        $builder->add('allowedFormats', ChoiceType::class, [
            'multiple' => true,
            'expanded' => true,
            'choices' => [
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                // 'gif' => 'image/gif',
                // 'webp' => 'image/webp',
                // 'svg+xml' => 'image/svg+xml',
            ],
            'constraints' => new Count(['min' => 1])
        ]);
    }
}