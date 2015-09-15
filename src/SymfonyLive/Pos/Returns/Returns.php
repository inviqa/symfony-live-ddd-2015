<?php

namespace SymfonyLive\Pos\Returns;

interface Returns 
{
    public function add(ProductReturn $return);
    public function update(ProductReturn $return);
    public function find(ReturnNumber $returnNumber);
}
