<?php

namespace Effiana\JobQueueBundle\Twig;

interface LinkGeneratorInterface
{
    function supports($entity);
    function generate($entity);
    function getLinkname($entity);
}