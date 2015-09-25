<?php

namespace SymfonyLive\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Registry;
use SymfonyLive\Infrastructure\Doctrine\EventSourcing\StoredEvent;
use SymfonyLive\Pos\Returns\ProductReturn;
use SymfonyLive\Pos\Returns\ReturnNumber;

class Returns implements \SymfonyLive\Pos\Returns\Returns
{
    private $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    public function update(ProductReturn $return)
    {
        $this->persistNewEvents($return);
    }

    public function add(ProductReturn $return)
    {
        $this->persistNewEvents($return);
    }

    public function find(ReturnNumber $returnNumber)
    {
        return ProductReturn::fromEvents(
            array_map(
                function (StoredEvent $storedEvent) {
                    return $storedEvent->getEvent();
                },
                $this->registry->getRepository(StoredEvent::class)->findByAggregateId($returnNumber->toString())
            )
        );
    }

    private function persistNewEvents(ProductReturn $return)
    {
        $createStoredEvent = function ($event, $eventNumber) use ($return) {
            return new StoredEvent($return->getAggregateId(), $eventNumber, $event);
        };

        $eventsToStore = array_map($createStoredEvent, $return->getNewEvents(), $this->getNewEventNumbers($return));
        array_walk($eventsToStore, [$this->registry->getManager(), 'persist']);

        $this->registry->getManager()->flush();
    }

    private function getNewEventNumbers(ProductReturn $return)
    {
        $numberOfExistingEvents = count($return->getEvents()) - count($return->getNewEvents());

        return array_filter(range($numberOfExistingEvents, count($return->getEvents())));
    }
}
