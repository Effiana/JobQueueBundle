<?php

namespace Effiana\JobQueueBundle\Command;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Effiana\JobQueueBundle\Entity\Job;
use Effiana\JobQueueBundle\Entity\Repository\JobManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MarkJobIncompleteCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'effiana:job-queue:mark-incomplete';

    private $registry;
    private $jobManager;

    public function __construct(ManagerRegistry $managerRegistry, JobManager $jobManager)
    {
        parent::__construct();

        $this->registry = $managerRegistry;
        $this->jobManager = $jobManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Internal command (do not use). It marks jobs as incomplete.')
            ->addArgument('job-id', InputArgument::REQUIRED, 'The ID of the Job.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->registry->getManagerForClass(Job::class);

        /** @var Job|null $job */
        $job = $em->createQuery("SELECT j FROM ".Job::class." j WHERE j.id = :id")
            ->setParameter('id', $input->getArgument('job-id'))
            ->getOneOrNullResult();

        if ($job === null) {
            $output->writeln('<error>Job was not found.</error>');

            return 1;
        }

        $this->jobManager->closeJob($job, Job::STATE_INCOMPLETE);

        return 0;
    }
}