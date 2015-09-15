<?php

namespace SymfonyLive\Infrastructure\Bus;

class CommandBus
{
    private $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function dispatch($command)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->canHandle($command)) {
                $handler->handle($command);
                return;
            }
        }

        throw new \InvalidArgumentException('No handler for ' . get_class($command));
    }
} 
