<?php

namespace Softspring\ImageBundle\EventListener\Admin;

use Softspring\CoreBundle\Event\ViewEvent;
use Softspring\CrudlBundle\Event\GetResponseEntityEvent;
use Softspring\ImageBundle\Manager\ImageManagerInterface;
use Softspring\ImageBundle\Manager\ImageTypeManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\SfsImageEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageListener implements EventSubscriberInterface
{
    /**
     * @var ImageManagerInterface
     */
    protected $imageManager;

    /**
     * @var ImageTypeManagerInterface
     */
    protected $imageTypesManager;

    /**
     * ImageListener constructor.
     */
    public function __construct(ImageManagerInterface $imageManager, ImageTypeManagerInterface $imageTypesManager)
    {
        $this->imageManager = $imageManager;
        $this->imageTypesManager = $imageTypesManager;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            SfsImageEvents::ADMIN_IMAGES_LIST_VIEW => 'onListViewAddTypes',
            SfsImageEvents::ADMIN_IMAGES_CREATE_INITIALIZE => 'onCreateInitializeAddType',
        ];
    }

    public function onListViewAddTypes(ViewEvent $event): void
    {
        $event->getData()['imageTypes'] = $this->imageTypesManager->getTypes();
    }

    public function onCreateInitializeAddType(GetResponseEntityEvent $event): void
    {
        $type = $event->getRequest()->attributes->get('type');

        /** @var ImageInterface $image */
        $image = $event->getEntity();
        $this->imageManager->fillEntityForType($image, $type);
    }
}
