<?php

use SymfonyLive\Pos\Purchase\Price;
use SymfonyLive\Pos\Purchase\Purchase;
use SymfonyLive\Pos\Purchase\Sku;
use SymfonyLive\Pos\Returns\RefundTimeframe;
use SymfonyLive\Pos\Returns\ProductReturn;
use SymfonyLive\Pos\Returns\ReturnNumber;

require 'vendor/autoload.php';

$return = new ProductReturn(
    new ReturnNumber('12345'),
    new Purchase(new Price(1000), new Sku('000-1')),
    new RefundTimeframe(new DateTimeImmutable('-28 days'), new DateTimeImmutable('now'))
);

try {
    $return->refundForCash();
    $return->refundForCredit();
}
catch (\Exception $exception) {
    echo 'Error: ' . get_class($exception) . PHP_EOL;
}
