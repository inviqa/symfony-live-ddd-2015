<?php

namespace SymfonyLive\Pos\Purchase;

class Sku 
{
    private $sku;

    public function __construct($string)
    {
        $this->sku = $string;
    }

    public function toString()
    {
        return $this->sku;
    }
} 
