<?php

namespace SymfonyLive\Pos\ReadModel\Returns;

class OutstandingReturn 
{
    public $returnNumber;
    public $sku;
    public $price;

    public function __construct($returnNumber, $sku, $price)
    {
        $this->returnNumber = $returnNumber;
        $this->sku = $sku;
        $this->price = $price;
    }
} 
