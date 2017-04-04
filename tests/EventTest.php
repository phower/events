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
}
