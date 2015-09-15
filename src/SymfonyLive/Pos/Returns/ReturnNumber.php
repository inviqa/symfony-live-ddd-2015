<?php

namespace SymfonyLive\Pos\Returns;

class ReturnNumber
{
    private $uuid;

    public  function __construct($uuid)
    {
        $this->uuid = $uuid;
    }

    public function toString()
    {
        return $this->uuid;
    }
} 
