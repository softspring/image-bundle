<?php

namespace Softspring\ImageBundle\Form\Admin;

use Softspring\ImageBundle\Form\ImageVersionType;
use Softspring\ImageBundle\Manager\ImageVersionManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;
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
     * @var array
     */
    protected $imageTypes;

    /**
     * AbstractImageForm constructor.
     *
     * @param ImageVersionManagerInterface $manager
     * @param array                        $imageTypes
     */
    public function __construct(ImageVersionManagerInterface $manager, array $imageTypes)
    {
        $this->manager = $manager;
        $this->imageTypes = $imageTypes;
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
        $resolver->setAllowedTypes('image_type', 'string');

        $resolver->setRequired('image');
        $resolver->setAllowedTypes('image', ImageInterface::class);
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $this->imageTypes[$options['image_type']];
        $image = $options['image'];
        $class = $this->manager->getEntityClass();

        $builder->add('_original', ImageVersionType::class, [
            'property_path' => "versions[_original]",
            'data' => new $class('_original', $image),
             'upload_requirements' => $type['upload_requirements'],
        ]);

        foreach ($type['versions'] as $key => $config) {
            if (!isset($config['upload_requirements'])) {
                continue;
            }
            $builder->add($key, ImageVersionType::class, [
                'property_path' => "versions[$key]",
                'data' => new $class($key, $image),
                'upload_requirements' => $type['upload_requirements'],
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