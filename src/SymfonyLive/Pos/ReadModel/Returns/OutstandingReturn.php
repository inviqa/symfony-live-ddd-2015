<?php

namespace SymfonyLive\Pos\ReadModel\Returns;

class OutstandingReturn 
{
    public $returnNumber;
    public $sku;
    public $price;
    public $refundableForCash;

    public function __construct($returnNumber, $sku, $price, $refundableForCash)
    {
        $this->returnNumber = $returnNumber;
        $this->sku = $sku;
        $this->price = $price;
        $this->refundableForCash = $refundableForCash;
    }
} 
