<?php

namespace SymfonyLive\Pos\Returns;

/**
 * CommandHandler
 */
class RefundForCashHandler
{
    private $returns;

    public function __construct(Returns $returns)
    {
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
    }
} 
