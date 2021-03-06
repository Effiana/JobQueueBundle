<?php

namespace Effiana\JobQueueBundle\Tests\Functional\TestBundle\Command;

use Effiana\JobQueueBundle\Console\CronCommand;
use Effiana\JobQueueBundle\Entity\Job;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScheduledEveryFewSecondsCommand extends Command implements CronCommand
{
    protected static $defaultName = 'scheduled-every-few-seconds';

    public function shouldBeScheduled(\DateTime $lastRunAt): bool
    {
        return time() - $lastRunAt->getTimestamp() >= 5;
    }

    public function createCronJob(\DateTime $_): Job
    {
        return new Job('scheduled-every-few-seconds');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Done');
    }
}