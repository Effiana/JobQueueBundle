<?php

namespace Effiana\JobQueueBundle\Entity\Listener;

use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

class StatisticsListener
{
    public function postGenerateSchema(GenerateSchemaEventArgs $event)
    {
        $schema = $event->getSchema();

        // When using multiple entity managers ignore events that are triggered by other entity managers.
        if ($event->getEntityManager()->getMetadataFactory()->isTransient('Effiana\JobQueueBundle\Entity\Job')) {
            return;
        }

        $table = $schema->createTable('effiana_job_statistics');
        $table->addColumn('job_id', 'bigint', array('notnull' => true, 'unsigned' => true));
        $table->addColumn('characteristic', 'string', array('length' => 30, 'notnull' => true));
        $table->addColumn('createdAt', 'datetime', array('notnull' => true));
        $table->addColumn('charValue', 'float', array('notnull' => true));
        $table->setPrimaryKey(array('job_id', 'characteristic', 'createdAt'));
    }
}