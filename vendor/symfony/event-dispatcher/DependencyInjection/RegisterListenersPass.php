<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher\DependencyInjection;

<<<<<<< HEAD
use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
=======
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
>>>>>>> web and vendor directory from composer install

/**
 * Compiler pass to register tagged services for an event dispatcher.
 */
class RegisterListenersPass implements CompilerPassInterface
{
<<<<<<< HEAD
    protected $dispatcherService;
    protected $listenerTag;
    protected $subscriberTag;

    private $hotPathEvents = array();
    private $hotPathTagName;

    /**
=======
    /**
     * @var string
     */
    protected $dispatcherService;

    /**
     * @var string
     */
    protected $listenerTag;

    /**
     * @var string
     */
    protected $subscriberTag;

    /**
     * Constructor.
     *
>>>>>>> web and vendor directory from composer install
     * @param string $dispatcherService Service name of the event dispatcher in processed container
     * @param string $listenerTag       Tag name used for listener
     * @param string $subscriberTag     Tag name used for subscribers
     */
    public function __construct($dispatcherService = 'event_dispatcher', $listenerTag = 'kernel.event_listener', $subscriberTag = 'kernel.event_subscriber')
    {
        $this->dispatcherService = $dispatcherService;
        $this->listenerTag = $listenerTag;
        $this->subscriberTag = $subscriberTag;
    }

<<<<<<< HEAD
    public function setHotPathEvents(array $hotPathEvents, $tagName = 'container.hot_path')
    {
        $this->hotPathEvents = array_flip($hotPathEvents);
        $this->hotPathTagName = $tagName;

        return $this;
    }

=======
>>>>>>> web and vendor directory from composer install
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->dispatcherService) && !$container->hasAlias($this->dispatcherService)) {
            return;
        }

        $definition = $container->findDefinition($this->dispatcherService);

<<<<<<< HEAD
        foreach ($container->findTaggedServiceIds($this->listenerTag, true) as $id => $events) {
=======
        foreach ($container->findTaggedServiceIds($this->listenerTag) as $id => $events) {
            $def = $container->getDefinition($id);
            if (!$def->isPublic()) {
                throw new \InvalidArgumentException(sprintf('The service "%s" must be public as event listeners are lazy-loaded.', $id));
            }

            if ($def->isAbstract()) {
                throw new \InvalidArgumentException(sprintf('The service "%s" must not be abstract as event listeners are lazy-loaded.', $id));
            }

>>>>>>> web and vendor directory from composer install
            foreach ($events as $event) {
                $priority = isset($event['priority']) ? $event['priority'] : 0;

                if (!isset($event['event'])) {
<<<<<<< HEAD
                    throw new InvalidArgumentException(sprintf('Service "%s" must define the "event" attribute on "%s" tags.', $id, $this->listenerTag));
=======
                    throw new \InvalidArgumentException(sprintf('Service "%s" must define the "event" attribute on "%s" tags.', $id, $this->listenerTag));
>>>>>>> web and vendor directory from composer install
                }

                if (!isset($event['method'])) {
                    $event['method'] = 'on'.preg_replace_callback(array(
                        '/(?<=\b)[a-z]/i',
                        '/[^a-z0-9]/i',
                    ), function ($matches) { return strtoupper($matches[0]); }, $event['event']);
                    $event['method'] = preg_replace('/[^a-z0-9]/i', '', $event['method']);
                }

<<<<<<< HEAD
                $definition->addMethodCall('addListener', array($event['event'], array(new ServiceClosureArgument(new Reference($id)), $event['method']), $priority));

                if (isset($this->hotPathEvents[$event['event']])) {
                    $container->getDefinition($id)->addTag($this->hotPathTagName);
                }
            }
        }

        $extractingDispatcher = new ExtractingEventDispatcher();

        foreach ($container->findTaggedServiceIds($this->subscriberTag, true) as $id => $attributes) {
            $def = $container->getDefinition($id);

            // We must assume that the class value has been correctly filled, even if the service is created by a factory
            $class = $def->getClass();

            if (!$r = $container->getReflectionClass($class)) {
                throw new InvalidArgumentException(sprintf('Class "%s" used for service "%s" cannot be found.', $class, $id));
            }
            if (!$r->isSubclassOf(EventSubscriberInterface::class)) {
                throw new InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, EventSubscriberInterface::class));
            }
            $class = $r->name;

            ExtractingEventDispatcher::$subscriber = $class;
            $extractingDispatcher->addSubscriber($extractingDispatcher);
            foreach ($extractingDispatcher->listeners as $args) {
                $args[1] = array(new ServiceClosureArgument(new Reference($id)), $args[1]);
                $definition->addMethodCall('addListener', $args);

                if (isset($this->hotPathEvents[$args[0]])) {
                    $container->getDefinition($id)->addTag('container.hot_path');
                }
            }
            $extractingDispatcher->listeners = array();
        }
    }
}

/**
 * @internal
 */
class ExtractingEventDispatcher extends EventDispatcher implements EventSubscriberInterface
{
    public $listeners = array();

    public static $subscriber;

    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->listeners[] = array($eventName, $listener[1], $priority);
    }

    public static function getSubscribedEvents()
    {
        $callback = array(self::$subscriber, 'getSubscribedEvents');

        return $callback();
=======
                $definition->addMethodCall('addListenerService', array($event['event'], array($id, $event['method']), $priority));
            }
        }

        foreach ($container->findTaggedServiceIds($this->subscriberTag) as $id => $attributes) {
            $def = $container->getDefinition($id);
            if (!$def->isPublic()) {
                throw new \InvalidArgumentException(sprintf('The service "%s" must be public as event subscribers are lazy-loaded.', $id));
            }

            if ($def->isAbstract()) {
                throw new \InvalidArgumentException(sprintf('The service "%s" must not be abstract as event subscribers are lazy-loaded.', $id));
            }

            // We must assume that the class value has been correctly filled, even if the service is created by a factory
            $class = $container->getParameterBag()->resolveValue($def->getClass());
            $interface = 'Symfony\Component\EventDispatcher\EventSubscriberInterface';

            if (!is_subclass_of($class, $interface)) {
                if (!class_exists($class, false)) {
                    throw new \InvalidArgumentException(sprintf('Class "%s" used for service "%s" cannot be found.', $class, $id));
                }

                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, $interface));
            }

            $definition->addMethodCall('addSubscriberService', array($id, $class));
        }
>>>>>>> web and vendor directory from composer install
    }
}
