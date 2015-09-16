<?php

namespace SymfonyLive\Pos\Returns;

use SymfonyLive\Infrastructure\Bus\EventBus;

/**
 * CommandHandler
 */
class ReturnProductHandler
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
        return $command instanceof ReturnProduct;
    }

    public function handle($command)
    {
        $productReturn = ProductReturn::returnProduct(
            $command->returnNumber(),
            $command->purchase(),
            $command->timeframe()
        );

        $this->returns->add($productReturn);

        $this->eventBus->dispatch($productReturn->getNewEvents());
    }
} 
