<?php

/**
 * Phower Events
 *
 * @version 0.0.0
 * @link https://github.com/phower/events Public Git repository
 * @copyright (c) 2015-2017, Pedro Ferreira <https://phower.com>
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Phower\Events;

use Phower\Container\ContainerAwareInterface;
use Phower\Container\ContainerAwareTrait;
use Psr\Container\ContainerInterface;

/**
 * Container aware event handler.
 *
 * @author Pedro Ferreira <pedro@phower.com>
 */
class ContainerAwareEventHandler implements EventHandlerInterface, ContainerAwareInterface
{

    /**
     * Iplement ContainerAwareInterface
     */
    use ContainerAwareTrait;

    /**
     * @var EventHandlerInterface
     */
    private $handler;

    /**
     * Create new instance of this class.
     *
     * @param ContainerInterface $container
     * @param EventHandlerInterface $handler
     */
    public function __construct(ContainerInterface $container, EventHandlerInterface $handler = null)
    {
        if (null === $handler) {
            $handler = new EventHandler();
        }

        $this->container = $container;
        $this->handler = $handler;
    }

    /**
     * Add listener.
     *
     * @param EventInterface|string $event
     * @param callable $listener
     * @param type $priority
     * @return EventHandler
     */
    public function addListener($event, $listener, $priority = 0)
    {
        if ($listener instanceof ContainerAwareInterface) {
            $listener->setContainer($this->container);
        } else if (is_array($listener) && 2 === count($listener) && $listener[0] instanceof ContainerAwareInterface) {
            $listener[0]->setContainer($this->container);
        }

        return $this->handler->addListener($event, $listener, $priority);
    }

    /**
     * Remove listener from event.
     *
     * @param EventInterface|string $event
     * @param callable $listener
     * @return EventHandler
     */
    public function removeListener($event, $listener)
    {
        return $this->handler->removeListener($event, $listener);
    }

    /**
     * Get listeners for a given event or all listeners if no event is specified.
     *
     * @param EventInterface|string|null $event
     * @return array
     */
    public function getListeners($event = null)
    {
        return $this->handler->getListeners($event);
    }

    /**
     * Trigger all listeners for a given event.
     *
     * @param EventInterface|string $event
     * @return EventInterface
     */
    public function trigger($event)
    {
        $this->handler->trigger($event);
    }
}
