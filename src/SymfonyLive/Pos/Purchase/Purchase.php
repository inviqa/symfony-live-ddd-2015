<?php

namespace SymfonyLive\Pos\Purchase;

class Purchase 
{
    private $price;

    private $sku;

    public function __construct(Price $price, Sku $sku)
    {
        $this->price = $price;
        $this->sku = $sku;
    }

    public function toString()
    {
        return $this->sku->toString() . '@' . $this->price->toString();
    }
} 
