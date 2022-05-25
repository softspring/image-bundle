<?php

namespace Softspring\ImageBundle\EventListener\Admin;

use Softspring\Component\CrudlController\Event\GetResponseEntityEvent;
use Softspring\CoreBundle\Event\ViewEvent;
use Softspring\ImageBundle\Manager\ImageManagerInterface;
use Softspring\ImageBundle\Manager\ImageTypeManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\SfsImageEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageListener implements EventSubscriberInterface
{
    protected ImageManagerInterface $imageManager;

    protected ImageTypeManagerInterface $imageTypesManager;

    public function __construct(ImageManagerInterface $imageManager, ImageTypeManagerInterface $imageTypesManager)
    {
        $this->imageManager = $imageManager;
        $this->imageTypesManager = $imageTypesManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SfsImageEvents::ADMIN_IMAGES_LIST_VIEW => 'onListViewAddTypes',
            SfsImageEvents::ADMIN_IMAGES_CREATE_INITIALIZE => 'onCreateInitializeAddType',
            SfsImageEvents::ADMIN_IMAGES_CREATE_VIEW => 'onCreateViewAddTypeConfig',
            SfsImageEvents::ADMIN_IMAGES_READ_VIEW => 'onReadViewAddTypeConfig',
        ];
    }

    public function onListViewAddTypes(ViewEvent $event): void
    {
        $event->getData()['image_types'] = $this->imageTypesManager->getTypes();
    }

    public function onCreateInitializeAddType(GetResponseEntityEvent $event): void
    {
        $type = $event->getRequest()->attributes->get('type');

        /** @var ImageInterface $image */
        $image = $event->getEntity();
        $this->imageManager->fillEntityForType($image, $type);
    }

    public function onCreateViewAddTypeConfig(ViewEvent $event): void
    {
        $event->getData()['type_config'] = $this->imageTypesManager->getType($event->getRequest()->attributes->get('type'));
    }

    public function onReadViewAddTypeConfig(ViewEvent $event): void
    {
        $event->getData()['type_config'] = $this->imageTypesManager->getType($event->getData()['image']->getType());
    }
}
