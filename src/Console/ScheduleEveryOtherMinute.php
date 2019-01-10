<?php

declare(strict_types = 1);

namespace Effiana\JobQueueBundle\Console;

trait ScheduleEveryOtherMinute
{
    use ScheduleInSecondInterval;

    protected function getScheduleInterval(): int
    {
        return 120;
    }
}