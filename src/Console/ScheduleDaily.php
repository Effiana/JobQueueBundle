<?php

declare(strict_types = 1);

namespace Effiana\JobQueueBundle\Console;

trait ScheduleDaily
{
    use ScheduleInSecondInterval;

    protected function getScheduleInterval(): int
    {
        return 86400;
    }
}