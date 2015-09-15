<?php

namespace SymfonyLive\Pos\Returns;

/**
 * Command
 */
class RefundForCash
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
