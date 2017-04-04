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
 * Event
 *
 * @author Pedro Ferreira <pedro@phower.com>
 */
class Event implements EventInterface
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $params;

    /**
     * Create a new instance of Event.
     *
     * @param string $name
     * @param array $params
     * @throws InvalidArgumentException
     */
    public function __construct($name, array $params = [])
    {
        if (!is_string($name) || '' === trim($name)) {
            throw new InvalidArgumentException('Argument "name" must be a string and can\'t be empty.');
        }

        $this->name = $name;
        $this->params = $params;
    }

    /**
     * Get event name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get all event params as array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->params;
    }
}
