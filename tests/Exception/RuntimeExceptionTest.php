<?php

namespace PhowerTest\Events\Exception;

class RuntimeExceptionTest extends \PHPUnit_Framework_TestCase
{

    public function testRuntimeExceptionExtendsRootRuntimeException()
    {
        $exception = new \Phower\Events\Exception\RuntimeException();
        $this->assertInstanceOf(\RuntimeException::class, $exception);
    }

    public function testRuntimeExceptionImplementsEventsExceptionInterface()
    {
        $exception = new \Phower\Events\Exception\RuntimeException();
        $this->assertInstanceOf(\Phower\Events\Exception\EventsExceptionInterface::class, $exception);
    }
}
