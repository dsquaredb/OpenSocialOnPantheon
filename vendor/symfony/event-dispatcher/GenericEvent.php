<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher;

/**
 * Event encapsulation class.
 *
 * Encapsulates events thus decoupling the observer from the subject they encapsulate.
 *
 * @author Drak <drak@zikula.org>
 */
class GenericEvent extends Event implements \ArrayAccess, \IteratorAggregate
{
<<<<<<< HEAD
    protected $subject;
=======
    /**
     * Event subject.
     *
     * @var mixed usually object or callable
     */
    protected $subject;

    /**
     * Array of arguments.
     *
     * @var array
     */
>>>>>>> web and vendor directory from composer install
    protected $arguments;

    /**
     * Encapsulate an event with $subject and $args.
     *
<<<<<<< HEAD
     * @param mixed $subject   The subject of the event, usually an object or a callable
=======
     * @param mixed $subject   The subject of the event, usually an object
>>>>>>> web and vendor directory from composer install
     * @param array $arguments Arguments to store in the event
     */
    public function __construct($subject = null, array $arguments = array())
    {
        $this->subject = $subject;
        $this->arguments = $arguments;
    }

    /**
     * Getter for subject property.
     *
     * @return mixed $subject The observer subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get argument by key.
     *
     * @param string $key Key
     *
     * @return mixed Contents of array key
     *
<<<<<<< HEAD
     * @throws \InvalidArgumentException if key is not found
=======
     * @throws \InvalidArgumentException If key is not found.
>>>>>>> web and vendor directory from composer install
     */
    public function getArgument($key)
    {
        if ($this->hasArgument($key)) {
            return $this->arguments[$key];
        }

        throw new \InvalidArgumentException(sprintf('Argument "%s" not found.', $key));
    }

    /**
     * Add argument to event.
     *
     * @param string $key   Argument name
     * @param mixed  $value Value
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return GenericEvent
>>>>>>> web and vendor directory from composer install
     */
    public function setArgument($key, $value)
    {
        $this->arguments[$key] = $value;

        return $this;
    }

    /**
     * Getter for all arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Set args property.
     *
     * @param array $args Arguments
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return GenericEvent
>>>>>>> web and vendor directory from composer install
     */
    public function setArguments(array $args = array())
    {
        $this->arguments = $args;

        return $this;
    }

    /**
     * Has argument.
     *
     * @param string $key Key of arguments array
     *
     * @return bool
     */
    public function hasArgument($key)
    {
        return array_key_exists($key, $this->arguments);
    }

    /**
     * ArrayAccess for argument getter.
     *
     * @param string $key Array key
     *
     * @return mixed
     *
<<<<<<< HEAD
     * @throws \InvalidArgumentException if key does not exist in $this->args
=======
     * @throws \InvalidArgumentException If key does not exist in $this->args.
>>>>>>> web and vendor directory from composer install
     */
    public function offsetGet($key)
    {
        return $this->getArgument($key);
    }

    /**
     * ArrayAccess for argument setter.
     *
     * @param string $key   Array key to set
     * @param mixed  $value Value
     */
    public function offsetSet($key, $value)
    {
        $this->setArgument($key, $value);
    }

    /**
     * ArrayAccess for unset argument.
     *
     * @param string $key Array key
     */
    public function offsetUnset($key)
    {
        if ($this->hasArgument($key)) {
            unset($this->arguments[$key]);
        }
    }

    /**
     * ArrayAccess has argument.
     *
     * @param string $key Array key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->hasArgument($key);
    }

    /**
     * IteratorAggregate for iterating over the object like an array.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->arguments);
    }
}
