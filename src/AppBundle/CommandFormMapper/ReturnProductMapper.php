<?php

namespace AppBundle\CommandFormMapper;

use SymfonyLive\Pos\Purchase\Price;
use SymfonyLive\Pos\Purchase\Purchase;
use SymfonyLive\Pos\Purchase\Sku;
use SymfonyLive\Pos\Returns\RefundTimeframe;
use SymfonyLive\Pos\Returns\ReturnNumber;
use SymfonyLive\Pos\Returns\ReturnProduct;

class ReturnProductMapper
{
    public $returnNumber;
    public $price;
    public $sku;
    public $purchaseDate;

    public function __construct($returnNumber = null)
    {
        $this->returnNumber = $returnNumber;
        $this->purchaseDate = new \DateTimeImmutable();
    }

    public function createCommand()
    {
        return new ReturnProduct(
            new ReturnNumber($this->returnNumber),
            new Purchase(new Price($this->price * 100), new Sku($this->sku)),
            new RefundTimeframe(
                new \DateTimeImmutable($this->purchaseDate->format(\DateTime::ATOM)),
                //\DateTimeImmutable::createFromMutable($this->purchaseDate), //>=5.6
                new \DateTimeImmutable('now')
            )
        );
    }
}