<?php

declare(strict_types = 1);

namespace Effiana\JobQueueBundle\Console;

trait ScheduleEveryMinute
{
    use ScheduleInSecondInterval;

    protected function getScheduleInterval(): int
    {
        return 60;
    }
}