<?php

namespace SymfonyLive\Pos\Returns;

/**
 * CommandHandler
 */
class ReturnProductHandler
{
    private $returns;

    public function __construct(Returns $returns)
    {
        $this->returns = $returns;
    }

    public function canHandle($command)
    {
        return $command instanceof ReturnProduct;
    }

    public function handle($command)
    {
        $productReturn = new ProductReturn($command->returnNumber(), $command->purchase(), $command->timeframe());
        $this->returns->add($productReturn);
    }
} 
