<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SymfonyLive\Pos\Returns\RefundForCash;
use SymfonyLive\Pos\Returns\RefundForCredit;
use SymfonyLive\Pos\Returns\ReturnNumber;

class RefundReturnCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('return:refund')
            ->setDescription('Refund a return')
            ->addArgument(
                'return-number',
                InputArgument::REQUIRED,
                'Return number'
            )
            ->addOption(
                'credit',
                'c',
                InputOption::VALUE_NONE,
                'Refund as credit'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $returnNumber = new ReturnNumber($input->getArgument('return-number'));

        if ($input->getOption('credit')) {
            $command = new RefundForCredit($returnNumber);
        } else {
            $command = new RefundForCash($returnNumber);
        }

        $this->getContainer()->get('symfony_live.pos.command_bus')->dispatch($command);

        $output->writeln('Refunded');
    }
} 
