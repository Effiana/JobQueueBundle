<?php

namespace Effiana\JobQueueBundle\Tests\Functional\TestBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SometimesFailingCommand extends \Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('effiana:job-queue:sometimes-failing-cmd')
            ->addArgument('time', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $expired = time() - $input->getArgument('time');

        if ($expired <= 6) {
            sleep(4);
            $output->writeln(sprintf('Failed (expired: %s seconds).', $expired));

            return 1;
        }

        $output->writeln('Success.');

        return 0;
    }
}