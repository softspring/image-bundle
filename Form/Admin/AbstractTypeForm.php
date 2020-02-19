<?php

namespace Softspring\ImageBundle\Form\Admin;

use Softspring\ImageBundle\Form\TypeDefinitionType;
use Softspring\ImageBundle\Model\ImageTypeInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Unique;

abstract class AbstractTypeForm extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageTypeInterface::class,
            'translation_domain' => 'sfs_image',
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('key', TextType::class, [
            'constraints' => [
                new NotBlank(),
                // new UniqueEntity(['fields' => 'key']),
            ]
        ]);
        $builder->add('definition', TypeDefinitionType::class);
    }
}