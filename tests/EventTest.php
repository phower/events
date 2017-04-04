<?php

namespace PhowerTest\Events;

use Phower\Events\Event;
use Phower\Events\EventInterface;

class EventTest extends \PHPUnit_Framework_TestCase
{

    public function testEventImplementsEventInterface()
    {
        $event = $this->getMockBuilder(Event::class)
                ->disableOriginalConstructor()
                ->getMock();
        $this->assertInstanceOf(EventInterface::class, $event);
    }

    public function testNameMustBeAStringAndCantBeEmpty()
    {
        $this->expectException(\Phower\Events\Exception\InvalidArgumentException::class);
        $event = new Event('');
    }

    public function testGetName()
    {
        $name = 'event_name';
        $event = new Event($name);
        $this->assertSame($name, $event->getName());
    }

    public function testToArray()
    {
        $name = 'event_name';
        $params = ['foo' => 'bar'];
        $event = new Event($name, $params);
        $this->assertSame($params, $event->toArray());
    }
}
