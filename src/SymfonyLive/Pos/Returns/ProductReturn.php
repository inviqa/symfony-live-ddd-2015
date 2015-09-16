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
    private $events = [];
    private $newEvents = [];

    private function __construct()
    {
    }

    public static function returnProduct(ReturnNumber $returnNumber, Purchase $purchase, RefundTimeframe $timeframe)
    {
        $productReturn = new self;
        $productReturn->raise(new ProductReturned($returnNumber, $purchase, $timeframe));

        return $productReturn;
    }

    public function refundForCredit()
    {
        $this->checkNotAlreadyRefunded();

        $this->raise(new RefundedForCredit($this->returnNumber));
    }

    public function refundForCash()
    {
        $this->checkNotAlreadyRefunded();

        if (!$this->timeframe->isWithinCashRefundPeriod()) {
            throw new RefundTimeframeExpired();
        }

        $this->raise(new RefundedForCash($this->returnNumber));
    }

    private function checkNotAlreadyRefunded()
    {
        if ($this->refund) {
            throw new ProductAlreadyRefunded();
        }
    }

    private function raise($event)
    {
        $this->events[] = $event;
        $this->newEvents[] = $event;
        $this->apply($event);
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function getNewEvents()
    {
        return $this->newEvents;
    }

    private function apply($event)
    {
        switch (get_class($event)) {
            case ProductReturned::class:
                $this->returnNumber = $event->returnNumber();
                $this->timeframe = $event->timeFrame();
                $this->purchase = $event->purchase();
                break;
            case RefundedForCredit::class:
                $this->refund = self::CREDIT_REFUND;
                break;
            case RefundedForCash::class:
                $this->refund = self::CASH_REFUND;
                break;
        }
    }

    public static function fromEvents(array $events)
    {
        $productReturn = new self;
        array_walk(
            $events,
            function ($event) use ($productReturn) {
                $productReturn->apply($event);
            }
        );

        $productReturn->events = $events;

        return $productReturn;
    }

    public function getAggregateId()
    {
        return $this->returnNumber->toString();
    }
} 
