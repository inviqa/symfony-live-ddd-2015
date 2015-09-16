<?php

namespace SymfonyLive\Infrastructure\Doctrine\EventSourcing;

class StoredEvent
{
    private $aggregateId;
    private $eventNumber;
    private $event;

    public function __construct($aggregateId, $eventNumber, $event)
    {
        $this->aggregateId = $aggregateId;
        $this->event = serialize($event);
        $this->eventNumber = $eventNumber;
    }

    public function getEvent()
    {
        return unserialize($this->event);
    }
}