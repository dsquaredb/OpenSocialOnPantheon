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
 * The EventDispatcherInterface is the central point of Symfony's event listener system.
 *
 * Listeners are registered on the manager and events are dispatched through the
 * manager.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Jonathan Wage <jonwage@gmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 * @author Bernhard Schussek <bschussek@gmail.com>
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Jordan Alliot <jordan.alliot@gmail.com>
<<<<<<< HEAD
 * @author Nicolas Grekas <p@tchwork.com>
=======
>>>>>>> web and vendor directory from composer install
 */
class EventDispatcher implements EventDispatcherInterface
{
    private $listeners = array();
    private $sorted = array();

    /**
     * {@inheritdoc}
     */
    public function dispatch($eventName, Event $event = null)
    {
        if (null === $event) {
            $event = new Event();
        }

<<<<<<< HEAD
=======
        $event->setDispatcher($this);
        $event->setName($eventName);

>>>>>>> web and vendor directory from composer install
        if ($listeners = $this->getListeners($eventName)) {
            $this->doDispatch($listeners, $eventName, $event);
        }

        return $event;
    }

    /**
     * {@inheritdoc}
     */
    public function getListeners($eventName = null)
    {
        if (null !== $eventName) {
<<<<<<< HEAD
            if (empty($this->listeners[$eventName])) {
=======
            if (!isset($this->listeners[$eventName])) {
>>>>>>> web and vendor directory from composer install
                return array();
            }

            if (!isset($this->sorted[$eventName])) {
                $this->sortListeners($eventName);
            }

            return $this->sorted[$eventName];
        }

        foreach ($this->listeners as $eventName => $eventListeners) {
            if (!isset($this->sorted[$eventName])) {
                $this->sortListeners($eventName);
            }
        }

        return array_filter($this->sorted);
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function getListenerPriority($eventName, $listener)
    {
        if (empty($this->listeners[$eventName])) {
            return;
        }

        if (is_array($listener) && isset($listener[0]) && $listener[0] instanceof \Closure) {
            $listener[0] = $listener[0]();
        }

        foreach ($this->listeners[$eventName] as $priority => $listeners) {
            foreach ($listeners as $k => $v) {
                if ($v !== $listener && is_array($v) && isset($v[0]) && $v[0] instanceof \Closure) {
                    $v[0] = $v[0]();
                    $this->listeners[$eventName][$priority][$k] = $v;
                }
                if ($v === $listener) {
                    return $priority;
                }
=======
     * Gets the listener priority for a specific event.
     *
     * Returns null if the event or the listener does not exist.
     *
     * @param string   $eventName The name of the event
     * @param callable $listener  The listener
     *
     * @return int|null The event listener priority
     */
    public function getListenerPriority($eventName, $listener)
    {
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $priority => $listeners) {
            if (false !== in_array($listener, $listeners, true)) {
                return $priority;
>>>>>>> web and vendor directory from composer install
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasListeners($eventName = null)
    {
<<<<<<< HEAD
        if (null !== $eventName) {
            return !empty($this->listeners[$eventName]);
        }

        foreach ($this->listeners as $eventListeners) {
            if ($eventListeners) {
                return true;
            }
        }

        return false;
=======
        return (bool) count($this->getListeners($eventName));
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->listeners[$eventName][$priority][] = $listener;
        unset($this->sorted[$eventName]);
    }

    /**
     * {@inheritdoc}
     */
    public function removeListener($eventName, $listener)
    {
<<<<<<< HEAD
        if (empty($this->listeners[$eventName])) {
            return;
        }

        if (is_array($listener) && isset($listener[0]) && $listener[0] instanceof \Closure) {
            $listener[0] = $listener[0]();
        }

        foreach ($this->listeners[$eventName] as $priority => $listeners) {
            foreach ($listeners as $k => $v) {
                if ($v !== $listener && is_array($v) && isset($v[0]) && $v[0] instanceof \Closure) {
                    $v[0] = $v[0]();
                }
                if ($v === $listener) {
                    unset($listeners[$k], $this->sorted[$eventName]);
                } else {
                    $listeners[$k] = $v;
                }
            }

            if ($listeners) {
                $this->listeners[$eventName][$priority] = $listeners;
            } else {
                unset($this->listeners[$eventName][$priority]);
=======
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $priority => $listeners) {
            if (false !== ($key = array_search($listener, $listeners, true))) {
                unset($this->listeners[$eventName][$priority][$key], $this->sorted[$eventName]);
>>>>>>> web and vendor directory from composer install
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
            if (is_string($params)) {
                $this->addListener($eventName, array($subscriber, $params));
            } elseif (is_string($params[0])) {
                $this->addListener($eventName, array($subscriber, $params[0]), isset($params[1]) ? $params[1] : 0);
            } else {
                foreach ($params as $listener) {
                    $this->addListener($eventName, array($subscriber, $listener[0]), isset($listener[1]) ? $listener[1] : 0);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
            if (is_array($params) && is_array($params[0])) {
                foreach ($params as $listener) {
                    $this->removeListener($eventName, array($subscriber, $listener[0]));
                }
            } else {
                $this->removeListener($eventName, array($subscriber, is_string($params) ? $params : $params[0]));
            }
        }
    }

    /**
     * Triggers the listeners of an event.
     *
     * This method can be overridden to add functionality that is executed
     * for each listener.
     *
     * @param callable[] $listeners The event listeners
     * @param string     $eventName The name of the event to dispatch
     * @param Event      $event     The event object to pass to the event handlers/listeners
     */
    protected function doDispatch($listeners, $eventName, Event $event)
    {
        foreach ($listeners as $listener) {
            if ($event->isPropagationStopped()) {
                break;
            }
<<<<<<< HEAD
            \call_user_func($listener, $event, $eventName, $this);
=======
            call_user_func($listener, $event, $eventName, $this);
>>>>>>> web and vendor directory from composer install
        }
    }

    /**
     * Sorts the internal list of listeners for the given event by priority.
     *
     * @param string $eventName The name of the event
     */
    private function sortListeners($eventName)
    {
        krsort($this->listeners[$eventName]);
<<<<<<< HEAD
        $this->sorted[$eventName] = array();

        foreach ($this->listeners[$eventName] as $priority => $listeners) {
            foreach ($listeners as $k => $listener) {
                if (\is_array($listener) && isset($listener[0]) && $listener[0] instanceof \Closure) {
                    $listener[0] = $listener[0]();
                    $this->listeners[$eventName][$priority][$k] = $listener;
                }
                $this->sorted[$eventName][] = $listener;
            }
        }
=======
        $this->sorted[$eventName] = call_user_func_array('array_merge', $this->listeners[$eventName]);
>>>>>>> web and vendor directory from composer install
    }
}
