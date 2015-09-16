<?php

namespace SymfonyLive\Pos\ReadModel\Returns;

use SymfonyLive\Pos\Returns\ReturnNumber;

interface OutstandingReturns
{
    public function add(OutstandingReturn $return);
    public function delete(ReturnNumber $returnNumber);
    public function findAll();
}
