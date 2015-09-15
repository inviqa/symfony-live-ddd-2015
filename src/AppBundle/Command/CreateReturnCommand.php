<?php

namespace AppBundle\Command;

use Rhumsaa\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SymfonyLive\Pos\Purchase\Price;
use SymfonyLive\Pos\Purchase\Purchase;
use SymfonyLive\Pos\Purchase\Sku;
use SymfonyLive\Pos\Returns\RefundTimeframe;
use SymfonyLive\Pos\Returns\ReturnNumber;
use SymfonyLive\Pos\Returns\ReturnProduct;

class CreateReturnCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('return:create')
            ->setDescription('Create a new return')
            ->addArgument(
                'price',
                InputArgument::REQUIRED,
                'Price in pence'
            )
            ->addArgument(
                'sku',
                InputArgument::REQUIRED,
                'Product SKU'
            )
            ->addArgument(
                'days',
                InputArgument::REQUIRED,
                'Days since purchase'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = new ReturnProduct(
            new ReturnNumber($returnNumber = Uuid::uuid4()),
            new Purchase(new Price($input->getArgument('price')), new Sku($input->getArgument('sku'))),
            new RefundTimeframe(new \DateTimeImmutable('-' . $input->getArgument(
                    'days'
                ) . ' days'), new \DateTimeImmutable('now'))
        );

        $this->getContainer()->get('symfony_live.pos.command_bus')->dispatch($command);

        $output->writeln('Processed with Return Number ' . $returnNumber->toString());
    }
} 
