<?php


namespace SymfonyLive\Infrastructure\Bus;

class EventBus 
{
    private $listeners;

    public function __construct(array $listeners)
    {
        $this->listeners = $listeners;
    }

    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            foreach ($this->listeners as $listener) {
                $listener->dispatch($event);
            }
        }
    }
} 
