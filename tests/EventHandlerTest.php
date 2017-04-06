<?php

namespace PhowerTest\Events;

use Phower\Events\EventHandler;
use Phower\Events\EventHandlerInterface;
use Phower\Events\EventInterface;

class EventHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function testEventHandlerImplementsEventHandlerInterface()
    {
        $handler = $this->getMockBuilder(EventHandler::class)
                ->disableOriginalConstructor()
                ->getMock();
        $this->assertInstanceOf(EventHandlerInterface::class, $handler);
    }

    public function testAddListenerCanAttachListenersToEvents()
    {
        $handler = new EventHandler();
        $self = $this;

        $event = 'some event';
        $listener = function (EventInterface $event, EvntHandlerInterface $handler) use ($self) {};
        $handler->addListener($event, $listener);
        $this->assertTrue(in_array($listener, $handler->getListeners($event)));
    }
}
