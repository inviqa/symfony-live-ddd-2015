<?php

namespace SymfonyLive\Pos\Returns;

use SymfonyLive\Pos\Purchase\Purchase;

class ProductReturn
{
    const NO_REFUND = 0;
    const CASH_REFUND = 1;
    const CREDIT_REFUND = 2;

    private $refund = self::NO_REFUND;
    private $timeframe;
    private $purchase;
    private $returnNumber;

    public function __construct(ReturnNumber $returnNumber, Purchase $purchase, RefundTimeframe $timeframe)
    {
        $this->returnNumber = $returnNumber;
        $this->timeframe = $timeframe;
        $this->purchase = $purchase;
    }

    public function refundForCredit()
    {
        $this->checkNotAlreadyRefunded();

        $this->refund = self::CREDIT_REFUND;
    }

    public function refundForCash()
    {
        $this->checkNotAlreadyRefunded();

        if (!$this->timeframe->isWithinCashRefundPeriod()) {
            throw new RefundTimeframeExpired();
        }

        $this->refund = self::CASH_REFUND;
    }

    private function checkNotAlreadyRefunded()
    {
        if ($this->refund) {
            throw new ProductAlreadyRefunded();
        }
    }
} 
