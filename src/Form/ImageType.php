<?php

namespace Softspring\ImageBundle\Form;

use Softspring\ImageBundle\Manager\ImageManagerInterface;
use Softspring\ImageBundle\Manager\ImageTypeManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    /**
     * @var ImageTypeManagerInterface
     */
    protected $imageTypeManager;

    /**
     * @var ImageManagerInterface
     */
    protected $imageManager;

    /**
     * ImageType constructor.
     */
    public function __construct(ImageTypeManagerInterface $imageTypeManager, ImageManagerInterface $imageManager)
    {
        $this->imageTypeManager = $imageTypeManager;
        $this->imageManager = $imageManager;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->imageManager->getEntityClass(),
            'image_type' => null,
        ]);

        $resolver->setRequired('image_type');
        $resolver->setAllowedTypes('image_type', 'string');
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typeDefinition = $this->imageTypeManager->getType($options['image_type']);

        $builder->add('_original', ImageVersionType::class, [
            'property_path' => 'versions[_original]',
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

        $builder->addEventListener(FormEvents::SUBMIT, function (SubmitEvent $event) use ($options) {
            /** @var ImageInterface $image */
            $image = $event->getData();
            $form = $event->getForm();

            if (!$image) {
                return;
            }

            $image->setType($options['image_type']);
            $image->markUploadedAtNow();
        });
    }
}
