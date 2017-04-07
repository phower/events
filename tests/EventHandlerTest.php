<?php

namespace PhowerTest\Events;

use Phower\Events\EventHandler;
use Phower\Events\EventHandlerInterface;
use Phower\Events\EventInterface;
use Phower\Events\Exception\InvalidArgumentException;

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
        $listener = function (EventInterface $event, EvntHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($event, $handler->getListeners($event)));
        };
        $handler->addListener($event, $listener);
        $this->assertTrue(in_array($listener, $handler->getListeners($event)));
    }

    public function testAddListenerRaisesExceptionWhenListenerIsNotCallable()
    {
        $handler = new EventHandler();

        $event = 'some event';
        $listener = 'not callable';

        $this->expectException(InvalidArgumentException::class);
        $handler->addListener($event, $listener);
    }

    public function testRemoveListenerCanRemoveListenersFromEvents()
    {
        $handler = new EventHandler();
        $self = $this;

        $event = 'some event';
        $listener = function (EventInterface $event, EvntHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($event, $handler->getListeners($event)));
        };
        $handler->addListener($event, $listener);
        $this->assertTrue(in_array($listener, $handler->getListeners($event)));

        $handler->removeListener($event, $listener);
        $this->assertFalse(in_array($listener, $handler->getListeners($event)));
    }

    public function testRemoveListenerDoesNothingWhenRequestedEventIsNotFound()
    {
        $handler = new EventHandler();
        $self = $this;

        $event = 'some event';
        $listener = function (EventInterface $event, EvntHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($event, $handler->getListeners($event)));
        };

        $handler->addListener($event, $listener);
        $this->assertEquals(1, count($handler->getListeners()));

        $handler->removeListener('other event', $listener);
        $this->assertEquals(1, count($handler->getListeners()));
    }

}
