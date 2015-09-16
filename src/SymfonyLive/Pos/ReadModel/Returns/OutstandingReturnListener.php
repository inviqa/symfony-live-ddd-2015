<?php

namespace SymfonyLive\Pos\ReadModel\Returns;

use SymfonyLive\Pos\Returns\ProductReturned;
use SymfonyLive\Pos\Returns\RefundedForCash;
use SymfonyLive\Pos\Returns\RefundedForCredit;

class OutstandingReturnListener
{
    private $repository;

    public function __construct(OutstandingReturns $repository)
    {
        $this->repository = $repository;
    }

    public function dispatch($event)
    {
        if ($event instanceof ProductReturned) {
            $this->dispatchProductReturned($event);
        }
        elseif ($event instanceof RefundedForCash) {
            $this->dispatchRefundedForCash($event);
        }
        elseif ($event instanceof RefundedForCredit) {
            $this->dispatchRefundedForCredit($event);
        }
    }

    private function dispatchProductReturned(ProductReturned $event)
    {
        $returnNumber = $event->returnNumber()->toString();
        $purchase = explode('@', $event->purchase()->toString());
        $refundableForCash = $event->timeframe()->isWithinCashRefundPeriod();

        $this->repository->add(new OutstandingReturn($returnNumber, $purchase[0], $purchase[1], $refundableForCash));
    }

    private function dispatchRefundedForCash(RefundedForCash $event)
    {
        $this->repository->delete($event->returnNumber());
    }

    private function dispatchRefundedForCredit(RefundedForCredit $event)
    {
        $this->repository->delete($event->returnNumber());
    }
} 
