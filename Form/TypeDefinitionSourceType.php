<?php

namespace Softspring\ImageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TypeDefinitionSourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('media', TextType::class);
        $builder->add('sizes', TextType::class);
        $builder->add('srcsetSuffix', TextType::class);
        $builder->add('required', CheckboxType::class);
    }
}