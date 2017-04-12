<?php

/**
 * Phower Events
 *
 * @version 1.0.0
 * @link https://github.com/phower/events Public Git repository
 * @copyright (c) 2015-2017, Pedro Ferreira <https://phower.com>
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Phower\Events;

/**
 * Event handler interface
 *
 * @author Pedro Ferreira <pedro@phower.com>
 */
interface EventHandlerInterface
{

    /**
     * Add listener.
     *
     * @param EventInterface|string $event
     * @param callable $listener
     * @param type $priority
     * @return EventHandlerInterface
     */
    public function addListener($event, $listener, $priority = 0);

    /**
     * Remove listener from event.
     *
     * @param EventInterface|string $event
     * @param callable $listener
     * @return EventHandlerInterface
     */
    public function removeListener($event, $listener);

    /**
     * Get listeners for a given event or all listeners if no event is specified.
     *
     * @param EventInterface|string|null $event
     * @return array
     */
    public function getListeners($event = null);

    /**
     * Trigger all listeners for a given event.
     *
     * @param EventInterface|string $event
     * @return EventInterface
     */
    public function trigger($event);
}
