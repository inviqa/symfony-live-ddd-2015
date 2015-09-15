<?php

namespace SymfonyLive\Pos\Returns;

/**
 * CommandHandler
 */
class RefundForCreditHandler
{
    private $returns;

    public function __construct(Returns $returns)
    {
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
    }
} 
