<?php

namespace Softspring\ImageBundle\Form;

use Softspring\ImageBundle\Model\ImageVersionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ImageVersionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageVersionInterface::class,
            'upload_requirements' => null,
        ]);

        $resolver->setAllowedTypes('upload_requirements', 'array');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('upload', FileType::class, [
            'required' => false,
            'constraints' => new Image($options['upload_requirements']),
        ]);
    }
}