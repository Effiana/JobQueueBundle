<?php
/**
 * This file is part of the Effiana package.
 *
 * (c) Effiana, LTD
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dominik Labudzinski <dominik@labudzinski.com>
 */
declare(strict_types=0);

namespace Effiana\JobQueueBundle\EventListener;

use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class JobCommandListener
 * @package Effiana\JobQueueBundle\EventListener
 */
class JobCommandListener
{
    /**
     * @param ConsoleCommandEvent $event
     */
    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $event->getCommand()->addOption('--jms-job-id', null, InputOption::VALUE_REQUIRED, 'The ID of the Job.');
    }
}