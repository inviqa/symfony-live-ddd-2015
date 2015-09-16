<?php

namespace SymfonyLive\Pos\Returns;

/**
 * Event
 */
class RefundedForCredit 
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
