<?php

/*
 * Copyright 2012 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Effiana\JobQueueBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * EffianaJobQueueBundle Configuration.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('effiana_job_queue');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->booleanNode('statistics')->defaultTrue()->end();

        $defaultOptionsNode = $rootNode
            ->children()
                ->arrayNode('queue_options_defaults')
                    ->addDefaultsIfNotSet();
        $this->addQueueOptions($defaultOptionsNode);

        $queueOptionsNode = $rootNode
            ->children()
                ->arrayNode('queue_options')
                    ->useAttributeAsKey('queue')
                    ->prototype('array');
        $this->addQueueOptions($queueOptionsNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $def
     */
    private function addQueueOptions(ArrayNodeDefinition $def): void
    {
        $def
            ->children()
                ->scalarNode('max_concurrent_jobs')->end()
        ;
    }
}
