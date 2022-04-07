<?php

namespace Softspring\ImageBundle\Form;

use Softspring\ImageBundle\Manager\ImageVersionManagerInterface;
use Softspring\ImageBundle\Model\ImageVersionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ImageVersionType extends AbstractType
{
    protected ImageVersionManagerInterface $imageVersionManager;

    public function __construct(ImageVersionManagerInterface $imageVersionManager)
    {
        $this->imageVersionManager = $imageVersionManager;
    }

    public function getBlockPrefix(): string
    {
        return 'image_version';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->imageVersionManager->getEntityClass(),
            'upload_requirements' => null,
        ]);

        $resolver->setAllowedTypes('upload_requirements', 'array');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('upload', FileType::class, [
            'required' => true,
            'constraints' => new Image($options['upload_requirements']),
        ]);

        $builder->addEventListener(FormEvents::SUBMIT, function (SubmitEvent $event) {
            /** @var ImageVersionInterface $imageVersion */
            $imageVersion = $event->getData();
            $form = $event->getForm();

            if (!$imageVersion) {
                return;
            }

            $imageVersion->setVersion('_original');
        });
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['upload_requirements'] = $options['upload_requirements'];
    }
}
