<?php

namespace Softspring\ImageBundle\Form;

use Softspring\ImageBundle\Manager\ImageTypeManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    /**
     * @var ImageTypeManagerInterface
     */
    protected $imageTypeManager;

    /**
     * ImageType constructor.
     *
     * @param ImageTypeManagerInterface $imageTypeManager
     */
    public function __construct(ImageTypeManagerInterface $imageTypeManager)
    {
        $this->imageTypeManager = $imageTypeManager;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageInterface::class,
            'image_type' => null,
        ]);

        $resolver->setRequired('image_type');
        $resolver->setAllowedTypes('image_type', 'string');
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typeDefinition = $this->imageTypeManager->getType($options['image_type']);

        $builder->add('_original', ImageVersionType::class, [
            'property_path' => "versions[_original]",
            'upload_requirements' => $typeDefinition['upload_requirements'],
        ]);

        foreach ($typeDefinition['versions'] as $key => $config) {
            if (!isset($config['upload_requirements'])) {
                continue;
            }
            $builder->add($key, ImageVersionType::class, [
                'property_path' => "versions[$key]",
                'upload_requirements' => $config['upload_requirements'],
            ]);
        }
    }
}