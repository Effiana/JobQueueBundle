<?php

namespace Effiana\JobQueueBundle\Tests\Functional;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

class CronTest extends BaseTestCase
{
    /** @var Application */
    private $app;

    /** @var EntityManager */
    private $em;

    public function testSchedulesCommands()
    {
        $output = $this->doRun(array('--min-job-interval' => 1, '--max-runtime' => 12));
        $this->assertEquals(2, substr_count($output, 'Scheduling command scheduled-every-few-seconds'), $output);
    }

    protected function setUp()
    {
        $this->createClient(array('config' => 'persistent_db.yml'));

        if (is_file($databaseFile = self::$kernel->getCacheDir().'/database.sqlite')) {
            unlink($databaseFile);
        }

        $this->importDatabaseSchema();

        $this->app = new Application(self::$kernel);
        $this->app->setAutoExit(false);
        $this->app->setCatchExceptions(false);

        $this->em = self::$kernel->getContainer()->get('doctrine')->getManagerForClass('EffianaJobQueueBundle:Job');
    }

    private function doRun(array $args = array())
    {
        array_unshift($args, 'effiana:job-queue:schedule');
        $output = new MemoryOutput();
        $this->app->run(new ArrayInput($args), $output);

        return $output->getOutput();
    }

}