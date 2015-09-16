<?php

namespace SymfonyLive\Pos\Returns;

use SymfonyLive\Infrastructure\Bus\EventBus;

/**
 * CommandHandler
 */
class RefundForCreditHandler
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
        return $command instanceof RefundForCredit;
    }

    public function handle(RefundForCredit $command)
    {
        if (!$return = $this->returns->find($command->returnNumber())) {
            throw new \RuntimeException('Cannot find return ');
        }

        $return->refundForCredit();

        $this->returns->update($return);

        $this->eventBus->dispatch($return->getEvents());
    }
} 
