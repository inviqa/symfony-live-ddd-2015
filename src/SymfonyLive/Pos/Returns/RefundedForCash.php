<?php

namespace SymfonyLive\Pos\Returns;

/**
 * Event
 */
class RefundedForCash 
{
    private $returnNumber;

    public function __construct(ReturnNumber $returnNumber)
    {
        $this->returnNumber = $returnNumber;
    }

    public function returnNumber()
    {
        return $this->returnNumber;
    }
} 
