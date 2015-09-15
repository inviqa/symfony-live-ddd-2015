<?php

namespace SymfonyLive\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Registry;
use SymfonyLive\Pos\Returns\ProductReturn;
use SymfonyLive\Pos\Returns\ReturnNumber;

class Returns implements \SymfonyLive\Pos\Returns\Returns
{
    private $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    public function update(ProductReturn $return)
    {
        $this->registry->getManager()->persist($return);
        $this->registry->getManager()->flush();
    }

    public function add(ProductReturn $return)
    {
        $this->update($return);
    }

    public function find(ReturnNumber $returnNumber)
    {
        return $this->registry->getRepository(ProductReturn::class)->find($returnNumber);
    }
}
