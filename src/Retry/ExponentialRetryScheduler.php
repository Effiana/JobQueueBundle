<?php

namespace Effiana\JobQueueBundle\Retry;

use Effiana\JobQueueBundle\Entity\Job;

class ExponentialRetryScheduler implements RetryScheduler
{
    private $base;

    public function __construct($base = 5)
    {
        $this->base = $base;
    }

    public function scheduleNextRetry(Job $originalJob)
    {
        return new \DateTime('+'.(pow($this->base, count($originalJob->getRetryJobs()))).' seconds');
    }
}