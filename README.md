Phower Events
=============

Events oriented programming for PHP.

Requirements
------------

Phower Events requires:

-   [PHP 5.6](http://php.net/releases/5_6_0.php) or above; 
    version [7.0](http://php.net/releases/7_0_0.php) is recommended

Instalation
-----------

Add Phower Events to any PHP project using [Composer](https://getcomposer.org/):

```bash
composer require phower/events
```

Usage
=====

This package provides an event-oriented mechanism which allows any PHP application to implement
a way for separated parts to communicate with each other by dispatching events and listening to them.

An implementation of PhowerEvents requires an EventHandler class and at least an event listener which
must be any valud [PHP callable](http://php.net/manual/en/language.types.callable.php):

```bash
use Phower\Events\EventHandlerInterface;
use Phower\Events\EventInterface;

class MyEventListener
{
    public onDummyEvent(EventInterface $event, EventHandlerInterface $handler)
    {
        print_r($event->getName());
        print_r($handler->getListeners($event));
    }
}
```

> Note that any listener method should always expect two arguments:
> 1. An instance of `EventInterface`, representing the event triggered;
> 2. An intance of `EventHandlerInterface`, the handler which have triggered that event.

Before being able to trigger the listner above we must to attach it to an handler instance:

```bash
use Phower\Events\EventHandler;

$handler = new EventHandler();
$handler->addListener('dummy', 'MyEventListener::onDummyEvent');

// later at any point where the handler is available:
$handler->trigger('dummy');
```

Running Tests
-------------

Tests are available in a separated namespace and can run with [PHPUnit](http://phpunit.de/)
in the command line:

```bash
vendor/bin/phpunit
```

Coding Standards
----------------

Phower code is written under [PSR-2](http://www.php-fig.org/psr/psr-2/) coding style standard.
To enforce that [CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) tools are also 
provided and can run as:

```bash
vendor/bin/phpcs
```

Reporting Issues
----------------

In case you find issues with this code please open a ticket in Github Issues at
[https://github.com/phower/container/issues](https://github.com/phower/container/issues).

Contributors
------------

Open Source is made of contribuition. If you want to contribute to Phower please
follow these steps:

1.  Fork latest version into your own repository.
2.  Write your changes or additions and commit them.
3.  Follow PSR-2 coding style standard.
4.  Make sure you have unit tests with full coverage to your changes.
5.  Go to Github Pull Requests at [https://github.com/phower/container/pulls](https://github.com/phower/container/pulls)
    and create a new request.

Thank you!

Changes and Versioning
----------------------

All relevant changes on this code are logged in a separated [log](CHANGELOG.md) file.

Version numbers follow recommendations from [Semantic Versioning](http://semver.org/).

License
-------

Phower code is maintained under [The MIT License](https://opensource.org/licenses/MIT).