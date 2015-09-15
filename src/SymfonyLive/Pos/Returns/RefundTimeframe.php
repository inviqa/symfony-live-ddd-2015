<?php


namespace SymfonyLive\Pos\Returns;


class RefundTimeframe 
{
    private $purchaseTime;

    private $refundTime;

    public function __construct(\DateTimeImmutable $purchaseTime, \DateTimeImmutable $refundTime)
    {
        $this->purchaseTime = $purchaseTime;
        $this->refundTime = $refundTime;
    }

    public function isWithinCashRefundPeriod()
    {
        return $this->refundTime->diff($this->purchaseTime)->days <= 30;
    }

    public function toString()
    {
        return $this->purchaseTime->format('c') . '--' . $this->refundTime->format('c');
    }
} 
