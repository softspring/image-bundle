<?php

namespace Softspring\ImageBundle\Form;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class ImageModalType extends AbstractType
{
    protected EntityManagerInterface $em;
    protected RouterInterface $router;

    public function __construct(EntityManagerInterface $em, RouterInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public function getBlockPrefix(): string
    {
        return 'image_modal';
    }

    public function getParent(): string
    {
        return HiddenType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => ImageInterface::class,
            'required' => false,
            'image_types' => [],
            'image_attr' => [],
            'show_thumbnail' => false,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CallbackTransformer(function ($value) {
            return $value;
        }, function ($value) {
            return is_string($value) ? $this->em->getRepository(ImageInterface::class)->findOneById($value) : $value;
        }));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['show_thumbnail'] = $options['show_thumbnail'];
        $view->vars['image_attr'] = $options['image_attr'];
        $view->vars['attr']["data-image-type-config"] = json_encode($options['image_types']);
        $view->vars['attr']["data-image-type-types"] = implode(',', array_keys($options['image_types']));
        $view->vars['modal_search_url'] = $this->router->generate('sfs_image_admin_images_search_type', [
            'valid_types' => implode(',', array_keys($options['image_types'])),
        ]);
    }
}