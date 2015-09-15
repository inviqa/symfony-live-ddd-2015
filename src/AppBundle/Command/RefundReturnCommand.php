<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
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
        $returns = $this->getContainer()->get('symfony_live.pos.returns');
        $returnNumber = new ReturnNumber($input->getArgument('return-number'));

        if (!$return = $returns->find($returnNumber)) {
            throw new \RuntimeException('Cannot find return ');
        }

        if ($input->getOption('credit')) {
            $return->refundForCredit();
        } else {
            $return->refundForCash();
        }

        $returns->update($return);

        $output->writeln('Refunded');
    }
} 
