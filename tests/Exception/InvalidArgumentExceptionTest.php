<?php

namespace PhowerTest\Events\Exception;

class InvalidArgumentExceptionTest extends \PHPUnit_Framework_TestCase
{

    public function testInvalidArgumentExceptionExtendsRootInvalidArgumentException()
    {
        $exception = new \Phower\Events\Exception\InvalidArgumentException();
        $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
    }

    public function testInvalidArgumentExceptionImplementsEventsExceptionInterface()
    {
        $exception = new \Phower\Events\Exception\InvalidArgumentException();
        $this->assertInstanceOf(\Phower\Events\Exception\EventsExceptionInterface::class, $exception);
    }
}
