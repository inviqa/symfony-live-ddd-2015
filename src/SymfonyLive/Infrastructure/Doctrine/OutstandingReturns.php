<?php

namespace SymfonyLive\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Registry;
use SymfonyLive\Pos\ReadModel\Returns\OutstandingReturn;
use SymfonyLive\Pos\Returns\ReturnNumber;

class OutstandingReturns implements \SymfonyLive\Pos\ReadModel\Returns\OutstandingReturns
{
    private $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    public function add(OutstandingReturn $return)
    {
        $this->registry->getManager()->persist($return);
        $this->registry->getManager()->flush();
    }

    public function delete(ReturnNumber $returnNumber)
    {
        $outstanding = $this->registry->getRepository(OutstandingReturn::class)->find($returnNumber->toString());
        $this->registry->getManager()->remove($outstanding);
        $this->registry->getManager()->flush();
    }

    public function findAll()
    {
        return $this->registry->getRepository(OutstandingReturn::class)->findAll();
    }
}
