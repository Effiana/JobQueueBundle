<?php

namespace Effiana\JobQueueBundle\Tests\Functional\TestBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SuccessfulCommand extends \Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('effiana:job-queue:successful-cmd')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}