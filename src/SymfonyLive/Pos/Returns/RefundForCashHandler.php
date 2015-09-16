<?php

namespace SymfonyLive\Pos\Returns;

use SymfonyLive\Infrastructure\Bus\EventBus;

/**
 * CommandHandler
 */
class RefundForCashHandler
{
    private $eventBus;
    private $returns;

    public function __construct(EventBus $eventBus, Returns $returns)
    {
        $this->eventBus = $eventBus;
        $this->returns = $returns;
    }

    public function canHandle($command)
    {
        return $command instanceof RefundForCash;
    }

    public function handle(RefundForCash $command)
    {
        if (!$return = $this->returns->find($command->returnNumber())) {
            throw new \RuntimeException('Cannot find return ');
        }

        $return->refundForCash();

        $this->returns->update($return);

        $this->eventBus->dispatch($return->getEvents());
    }
} 
