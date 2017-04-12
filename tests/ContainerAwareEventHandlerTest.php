<?php

namespace PhowerTest\Events;

use Phower\Events\ContainerAwareEventHandler;
use Phower\Events\EventHandlerInterface;
use Phower\Events\EventInterface;
use Phower\Events\Exception\InvalidArgumentException;
use Phower\Container\Container;
use Phower\Container\ContainerAwareInterface;
use Psr\Container\ContainerInterface;

class ContainerAwareEventHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function testContainerAwareEventHandlerImplementsEventHandlerInterface()
    {
        $container = new Container();
        $handler = new ContainerAwareEventHandler($container);

        $this->assertInstanceOf(EventHandlerInterface::class, $handler);
    }

    public function testContainerAwareEventHandlerImplementsContainerAwareInterface()
    {
        $container = new Container();
        $handler = new ContainerAwareEventHandler($container);

        $this->assertInstanceOf(ContainerAwareInterface::class, $handler);
    }

    public function testAddListenerCanAttachListenersToEvents()
    {
        $container = new Container();
        $handler = new ContainerAwareEventHandler($container);

        $self = $this;

        $event1 = 'some event';
        $event2 = new \Phower\Events\Event('another event');
        $listener = function (EventInterface $event, EventHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($handler->getListeners($event)));
        };
        $handler->addListener($event1, $listener);
        $handler->addListener($event2, $listener);
        $this->assertTrue(in_array($listener, $handler->getListeners($event1)));
    }

    public function testAddListenerSetContainerOnContainerAwareListeners()
    {
        $container = new Container();
        $handler = new ContainerAwareEventHandler($container);

        $event = 'some event';
        $listener = new ContainerAwareListenerStub();
        $this->assertNull($listener->getContainer());

        $handler->addListener($event, ContainerAwareListenerStub::class . '::onEvent');
        $this->assertNull($listener->getContainer());

        $handler->addListener($event, $listener);
        $handler->addListener($event, [$listener, 'onEvent']);
        $this->assertSame($container, $listener->getContainer());
    }

    public function testAddListenerRaisesExceptionWhenListenerIsNotCallable()
    {
        $container = new Container();
        $handler = new ContainerAwareEventHandler($container);


        $event = 'some event';
        $listener = 'not callable';

        $this->expectException(InvalidArgumentException::class);
        $handler->addListener($event, $listener);
    }

    public function testRemoveListenerCanRemoveListenersFromEvents()
    {
        $container = new Container();
        $handler = new ContainerAwareEventHandler($container);

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
        $container = new Container();
        $handler = new ContainerAwareEventHandler($container);

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

    public function testTriggerMustInvokeListenerWithEventAndHandlerAsArguments()
    {
        $container = new Container();
        $handler = new ContainerAwareEventHandler($container);

        $self = $this;

        $event = 'some event';
        $listener = function (EventInterface $event, EventHandlerInterface $handler) use ($self) {
            $self->assertEquals(1, count($handler->getListeners($event)));
        };

        $handler->addListener($event, $listener);
        $handler->trigger($event);
    }
}
