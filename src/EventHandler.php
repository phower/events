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

use Phower\Events\Exception\InvalidArgumentException;

/**
 * Event handler.
 *
 * @author Pedro Ferreira <pedro@phower.com>
 */
class EventHandler implements EventHandlerInterface
{

    /**
     * @var array
     */
    private $listeners = [];

    /**
     * @var array
     */
    private $sorted = [];

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
        $name = $this->getEventName($event);

        if (!is_callable($listener)) {
            throw new InvalidArgumentException('Listener must be a valid callable.');
        }

        $this->listeners[$name][(int) $priority][] = $listener;
        unset($this->sorted[$name]);

        return $this;
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
        $name = $this->getEventName($event);

        if (!isset($this->listeners[$name])) {
            return $this;
        }

        foreach ($this->listeners[$name] as $priority => $listeners) {
            if (false !== ($key = array_search($listener, $listeners, true))) {
                unset($this->listeners[$name][$priority][$key], $this->sorted[$name]);
            }
        }

        return $this;
    }

    /**
     * Get listeners for a given event or all listeners if no event is specified.
     *
     * @param EventInterface|string|null $event
     * @return array
     */
    public function getListeners($event = null)
    {
        if (null !== $event) {
            $name = $this->getEventName($event);

            if (!isset($this->listeners[$name])) {
                return [];
            }

            if (!isset($this->sorted[$name])) {
                $this->sortListeners($name);
            }

            return $this->sorted[$name];
        }

        $this->sortListeners();

        return $this->sorted;
    }

    /**
     * Trigger all listeners for a given event.
     *
     * @param EventInterface|string $event
     * @return EventInterface
     */
    public function trigger($event)
    {
        if (is_string($event)) {
            if ('' === trim($event)) {
                throw new InvalidArgumentException('Event name can\'t be an empty string.');
            }

            $event = new Event($event);
        }

        if (!$event instanceof EventInterface) {
            throw new InvalidArgumentException('Event must an instance of ' . EventInterface::class);
        }

        foreach ($this->getListeners($event) as $listener) {
            call_user_func($listener, $event, $this);
        }
    }

    /**
     * Get event name.
     *
     * @param \Phower\Events\EventInterface|string $event
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getEventName($event)
    {
        $name = $event instanceof EventInterface ? $event->getName() : (string) $event;

        if (!is_string($name) || '' === trim($name)) {
            throw new InvalidArgumentException('Event name must be a string and can\'t be empty.');
        }

        return $name;
    }

    /**
     * Sort internal array of listeners by priority.
     *
     * @param string $name
     * */
    protected function sortListeners($name = null)
    {
        if (null === $name) {
            foreach ($this->listeners as $name => $listener) {
                if (!isset($this->sorted[$name])) {
                    $this->sortListeners($name);
                }
            }

            return;
        }

        krsort($this->listeners[$name]);
        $this->sorted[$name] = call_user_func_array('array_merge', $this->listeners[$name]);
    }

}
