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
        $listener = function (EventInterface $event, EventHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($handler->getListeners($event)));
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
        $listener = function (EventInterface $event, EventHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($handler->getListeners($event)));
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
        $listener = function (EventInterface $event, EventHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($handler->getListeners($event)));
        };

        $handler->addListener($event, $listener);
        $this->assertEquals(1, count($handler->getListeners()));

        $handler->removeListener('other event', $listener);
        $this->assertEquals(1, count($handler->getListeners()));
    }

    public function testGetListenersReturnsOrderedArrayOfListenersOfGivenEvent()
    {
        $handler = new EventHandler();
        $self = $this;

        $event = 'some event';
        $listener1 = function (EventInterface $event, EventHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($handler->getListeners($event)));
        };
        $listener2 = function (EventInterface $event, EventHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($handler->getListeners($event)));
        };
        $listener3 = function (EventInterface $event, EventHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($handler->getListeners($event)));
        };

        $handler->addListener($event, $listener1, 1);
        $handler->addListener($event, $listener2, 3);
        $handler->addListener($event, $listener3, 2);

        $expected = [
            $listener2,
            $listener3,
            $listener1,
        ];

        $this->assertSame($expected, $handler->getListeners($event));
    }

    public function testGetListenersReturnsEmptyArrayWhenEventIsNotFound()
    {
        $handler = new EventHandler();
        $this->assertSame([], $handler->getListeners('unknown event'));
    }

    public function testGetEventNameRaisesExceptionOnNonStringName()
    {
        $handler = new EventHandler();
        $this->expectException(InvalidArgumentException::class);
        $handler->getListeners(1);
    }

    public function testGetEventNameRaisesExceptionOnEmptyStringName()
    {
        $handler = new EventHandler();
        $this->expectException(InvalidArgumentException::class);
        $handler->getListeners('');
    }

    public function testTriggerInvokesListenersForGivenEvent()
    {
        $handler = new EventHandler();
        $self = $this;

        $event = 'some event';
        $listener = function (EventInterface $event, EventHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($handler->getListeners($event)));
        };

        $handler->addListener($event, $listener);
        $handler->trigger($event);
    }

    public function testTriggerRaisesExceptionOnEmptyEventName()
    {
        $handler = new EventHandler();
        $this->expectException(InvalidArgumentException::class);
        $handler->trigger('');
    }

    public function testTriggerRaisesExceptionOnNotIntanceOfEventInterface()
    {
        $handler = new EventHandler();
        $this->expectException(InvalidArgumentException::class);
        $handler->trigger(new \stdClass());
    }
}
