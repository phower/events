<?php

namespace PhowerTest\Events;

use Phower\Container\ContainerAwareTrait;
use Phower\Container\ContainerAwareInterface;
use Phower\Events\ContainerAwareEventHandlerInterface;
use Phower\Events\EventInterface;

class ContainerAwareListenerStub implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    public function onEvent(EventInterface $event, ContainerAwareEventHandlerInterface $handler)
    {
        // does nothing
    }

    public function __invoke(EventInterface $event, ContainerAwareEventHandlerInterface $handler)
    {
        
    }
}
