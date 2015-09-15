<?php

namespace SymfonyLive\Pos\Returns;

use SymfonyLive\Pos\Purchase\Purchase;

/**
 * Command
 */
class ReturnProduct
{
    private $returnNumber;
    private $purchase;
    private $timeframe;

    public function __construct(ReturnNumber $returnNumber, Purchase $purchase, RefundTimeframe $timeframe)
    {
        $this->returnNumber = $returnNumber;
        $this->purchase = $purchase;
        $this->timeframe = $timeframe;
    }

    public function purchase()
    {
        return $this->purchase;
    }

    public function returnNumber()
    {
        return $this->returnNumber;
    }

    public function timeframe()
    {
        return $this->timeframe;
    }
}
