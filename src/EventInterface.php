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

/**
 * Event interface
 *
 * @author Pedro Ferreira <pedro@phower.com>
 */
interface EventInterface
{

    /**
     * Get event name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get all event params as array.
     *
     * @return array
     */
    public function toArray();
}
