<?php

namespace Softspring\ImageBundle\Form\Admin;

use Softspring\ImageBundle\Form\ImageVersionType;
use Softspring\ImageBundle\Manager\ImageVersionManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\Model\ImageTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractImageForm extends AbstractType
{
    /**
     * @var ImageVersionManagerInterface
     */
    protected $manager;

    /**
     * ImageVersionType constructor.
     *
     * @param ImageVersionManagerInterface $manager
     */
    public function __construct(ImageVersionManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageInterface::class,
            'translation_domain' => 'sfs_image',
            'image_type' => null,
            'image' => null,
        ]);

        $resolver->setRequired('image_type');
        $resolver->setAllowedTypes('image_type', ImageTypeInterface::class);

        $resolver->setRequired('image');
        $resolver->setAllowedTypes('image', ImageInterface::class);
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $options['image_type'];
        $image = $options['image'];
        $class = $this->manager->getEntityClass();

        foreach ($type->getDefinition() as $key => $definition) {
            $builder->add($key, ImageVersionType::class, [
                'property_path' => "versions[$key]",
                'data' => new $class($key, $image),
            ]);
        }
    }

    public function formOptions(ImageInterface $entity, Request $request): array
    {
        return [
            'image_type' => $entity->getType(),
            'image' => $entity,
        ];
    }
}