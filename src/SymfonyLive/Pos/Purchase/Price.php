<?php


namespace SymfonyLive\Pos\Purchase;

class Price 
{
    private $pence;

    public function __construct($pence)
    {
        $this->pence = $pence;
    }

    public function toString()
    {
        return sprintf('£%01.2f', $this->pence/100);
    }
} 
