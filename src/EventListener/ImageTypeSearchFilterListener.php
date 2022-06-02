<?php

namespace Softspring\ImageBundle\EventListener;

use Softspring\Component\CrudlController\Event\FilterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ImageTypeSearchFilterListener implements EventSubscriberInterface
{
    protected RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'sfs_image.search_filter.filter_event' => 'onFilterEvent',
        ];
    }

    public function onFilterEvent(FilterEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $validTypes = explode(',', $request->attributes->get('valid_types'));

        $filters = $event->getFilters();
        $filters['type_in'] = $filters['type_in'] ?? $validTypes;

        $event->setFilters($filters);
    }
}
