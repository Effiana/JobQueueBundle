<?php

declare(strict_types = 1);

namespace Effiana\JobQueueBundle\Console;

trait ScheduleHourly
{
    use ScheduleInSecondInterval;

    protected function getScheduleInterval(): int
    {
        return 3600;
    }
}