<?php

namespace Softspring\ImageBundle\EventListener\Admin;

use Softspring\CoreBundle\Event\ViewEvent;
use Softspring\CrudlBundle\Event\GetResponseEntityEvent;
use Softspring\ImageBundle\Model\ImageInterface;
use Softspring\ImageBundle\SfsImageEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageListener implements EventSubscriberInterface
{
    /**
     * @var array
     */
    protected $imageTypes;

    /**
     * ImageListener constructor.
     *
     * @param array $imageTypes
     */
    public function __construct(array $imageTypes)
    {
        $this->imageTypes = $imageTypes;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SfsImageEvents::ADMIN_IMAGES_LIST_VIEW => 'onListViewAddTypes',
            SfsImageEvents::ADMIN_IMAGES_CREATE_INITIALIZE => 'onCreateInitializeAddType',
        ];
    }

    /**
     * @param ViewEvent $event
     */
    public function onListViewAddTypes(ViewEvent $event): void
    {
        $event->getData()['imageTypes'] = $this->imageTypes;
    }

    /**
     * @param GetResponseEntityEvent $event
     */
    public function onCreateInitializeAddType(GetResponseEntityEvent $event): void
    {
        $type = $event->getRequest()->attributes->get('type');

        /** @var ImageInterface $image */
        $image = $event->getEntity();
        $image->setType($type);
    }
}