<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection;

<<<<<<< HEAD
use Symfony\Component\DependencyInjection\Argument\BoundArgument;
=======
>>>>>>> web and vendor directory from composer install
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\OutOfBoundsException;

/**
 * Definition represents a service definition.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Definition
{
    private $class;
    private $file;
    private $factory;
<<<<<<< HEAD
    private $shared = true;
    private $deprecated = false;
    private $deprecationTemplate;
    private $properties = array();
    private $calls = array();
    private $instanceof = array();
    private $autoconfigured = false;
    private $configurator;
    private $tags = array();
    private $public = true;
    private $private = true;
    private $synthetic = false;
    private $abstract = false;
=======
    private $factoryClass;
    private $factoryMethod;
    private $factoryService;
    private $shared = true;
    private $deprecated = false;
    private $deprecationTemplate = 'The "%service_id%" service is deprecated. You should stop using it, as it will soon be removed.';
    private $scope = ContainerInterface::SCOPE_CONTAINER;
    private $properties = array();
    private $calls = array();
    private $configurator;
    private $tags = array();
    private $public = true;
    private $synthetic = false;
    private $abstract = false;
    private $synchronized = false;
>>>>>>> web and vendor directory from composer install
    private $lazy = false;
    private $decoratedService;
    private $autowired = false;
    private $autowiringTypes = array();
<<<<<<< HEAD
    private $changes = array();
    private $bindings = array();
    private $errors = array();

    protected $arguments = array();

    private static $defaultDeprecationTemplate = 'The "%service_id%" service is deprecated. You should stop using it, as it will soon be removed.';
=======

    protected $arguments;
>>>>>>> web and vendor directory from composer install

    /**
     * @param string|null $class     The service class
     * @param array       $arguments An array of arguments to pass to the service constructor
     */
    public function __construct($class = null, array $arguments = array())
    {
<<<<<<< HEAD
        if (null !== $class) {
            $this->setClass($class);
        }
=======
        $this->class = $class;
>>>>>>> web and vendor directory from composer install
        $this->arguments = $arguments;
    }

    /**
<<<<<<< HEAD
     * Returns all changes tracked for the Definition object.
     *
     * @return array An array of changes for this Definition
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * Sets the tracked changes for the Definition object.
     *
     * @param array $changes An array of changes for this Definition
     *
     * @return $this
     */
    public function setChanges(array $changes)
    {
        $this->changes = $changes;
=======
     * Sets a factory.
     *
     * @param string|array $factory A PHP function or an array containing a class/Reference and a method to call
     *
     * @return Definition The current instance
     */
    public function setFactory($factory)
    {
        if (is_string($factory) && strpos($factory, '::') !== false) {
            $factory = explode('::', $factory, 2);
        }

        $this->factory = $factory;

        return $this;
    }

    /**
     * Gets the factory.
     *
     * @return string|array The PHP function or an array containing a class/Reference and a method to call
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Sets the name of the class that acts as a factory using the factory method,
     * which will be invoked statically.
     *
     * @param string $factoryClass The factory class name
     *
     * @return Definition The current instance
     *
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    public function setFactoryClass($factoryClass)
    {
        @trigger_error(sprintf('%s(%s) is deprecated since version 2.6 and will be removed in 3.0. Use Definition::setFactory() instead.', __METHOD__, $factoryClass), E_USER_DEPRECATED);

        $this->factoryClass = $factoryClass;
>>>>>>> web and vendor directory from composer install

        return $this;
    }

    /**
<<<<<<< HEAD
     * Sets a factory.
     *
     * @param string|array $factory A PHP function or an array containing a class/Reference and a method to call
     *
     * @return $this
     */
    public function setFactory($factory)
    {
        $this->changes['factory'] = true;

        if (is_string($factory) && false !== strpos($factory, '::')) {
            $factory = explode('::', $factory, 2);
        }

        $this->factory = $factory;

        return $this;
    }

    /**
     * Gets the factory.
     *
     * @return string|array The PHP function or an array containing a class/Reference and a method to call
     */
    public function getFactory()
    {
        return $this->factory;
=======
     * Gets the factory class.
     *
     * @return string|null The factory class name
     *
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    public function getFactoryClass($triggerDeprecationError = true)
    {
        if ($triggerDeprecationError) {
            @trigger_error('The '.__METHOD__.' method is deprecated since version 2.6 and will be removed in 3.0.', E_USER_DEPRECATED);
        }

        return $this->factoryClass;
    }

    /**
     * Sets the factory method able to create an instance of this class.
     *
     * @param string $factoryMethod The factory method name
     *
     * @return Definition The current instance
     *
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    public function setFactoryMethod($factoryMethod)
    {
        @trigger_error(sprintf('%s(%s) is deprecated since version 2.6 and will be removed in 3.0. Use Definition::setFactory() instead.', __METHOD__, $factoryMethod), E_USER_DEPRECATED);

        $this->factoryMethod = $factoryMethod;

        return $this;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Sets the service that this service is decorating.
     *
     * @param null|string $id        The decorated service id, use null to remove decoration
     * @param null|string $renamedId The new decorated service id
     * @param int         $priority  The priority of decoration
     *
<<<<<<< HEAD
     * @return $this
     *
     * @throws InvalidArgumentException in case the decorated service id and the new decorated service id are equals
     */
    public function setDecoratedService($id, $renamedId = null, $priority = 0)
    {
        if ($renamedId && $id === $renamedId) {
            throw new InvalidArgumentException(sprintf('The decorated service inner name for "%s" must be different than the service name itself.', $id));
        }

        $this->changes['decorated_service'] = true;

=======
     * @return Definition The current instance
     *
     * @throws InvalidArgumentException In case the decorated service id and the new decorated service id are equals.
     */
    public function setDecoratedService($id, $renamedId = null, $priority = 0)
    {
        if ($renamedId && $id == $renamedId) {
            throw new \InvalidArgumentException(sprintf('The decorated service inner name for "%s" must be different than the service name itself.', $id));
        }

>>>>>>> web and vendor directory from composer install
        if (null === $id) {
            $this->decoratedService = null;
        } else {
            $this->decoratedService = array($id, $renamedId, (int) $priority);
        }

        return $this;
    }

    /**
<<<<<<< HEAD
     * Gets the service that this service is decorating.
=======
     * Gets the service that decorates this service.
>>>>>>> web and vendor directory from composer install
     *
     * @return null|array An array composed of the decorated service id, the new id for it and the priority of decoration, null if no service is decorated
     */
    public function getDecoratedService()
    {
        return $this->decoratedService;
    }

    /**
<<<<<<< HEAD
=======
     * Gets the factory method.
     *
     * @return string|null The factory method name
     *
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    public function getFactoryMethod($triggerDeprecationError = true)
    {
        if ($triggerDeprecationError) {
            @trigger_error('The '.__METHOD__.' method is deprecated since version 2.6 and will be removed in 3.0.', E_USER_DEPRECATED);
        }

        return $this->factoryMethod;
    }

    /**
     * Sets the name of the service that acts as a factory using the factory method.
     *
     * @param string $factoryService The factory service id
     *
     * @return Definition The current instance
     *
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    public function setFactoryService($factoryService, $triggerDeprecationError = true)
    {
        if ($triggerDeprecationError) {
            @trigger_error(sprintf('%s(%s) is deprecated since version 2.6 and will be removed in 3.0. Use Definition::setFactory() instead.', __METHOD__, $factoryService), E_USER_DEPRECATED);
        }

        $this->factoryService = $factoryService;

        return $this;
    }

    /**
     * Gets the factory service id.
     *
     * @return string|null The factory service id
     *
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    public function getFactoryService($triggerDeprecationError = true)
    {
        if ($triggerDeprecationError) {
            @trigger_error('The '.__METHOD__.' method is deprecated since version 2.6 and will be removed in 3.0.', E_USER_DEPRECATED);
        }

        return $this->factoryService;
    }

    /**
>>>>>>> web and vendor directory from composer install
     * Sets the service class.
     *
     * @param string $class The service class
     *
<<<<<<< HEAD
     * @return $this
     */
    public function setClass($class)
    {
        $this->changes['class'] = true;

=======
     * @return Definition The current instance
     */
    public function setClass($class)
    {
>>>>>>> web and vendor directory from composer install
        $this->class = $class;

        return $this;
    }

    /**
     * Gets the service class.
     *
     * @return string|null The service class
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Sets the arguments to pass to the service constructor/factory method.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @param array $arguments An array of arguments
     *
     * @return Definition The current instance
>>>>>>> web and vendor directory from composer install
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

<<<<<<< HEAD
    /**
     * Sets the properties to define when creating the service.
     *
     * @return $this
     */
=======
>>>>>>> web and vendor directory from composer install
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

<<<<<<< HEAD
    /**
     * Gets the properties to define when creating the service.
     *
     * @return array
     */
=======
>>>>>>> web and vendor directory from composer install
    public function getProperties()
    {
        return $this->properties;
    }

<<<<<<< HEAD
    /**
     * Sets a specific property.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
=======
>>>>>>> web and vendor directory from composer install
    public function setProperty($name, $value)
    {
        $this->properties[$name] = $value;

        return $this;
    }

    /**
     * Adds an argument to pass to the service constructor/factory method.
     *
     * @param mixed $argument An argument
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return Definition The current instance
>>>>>>> web and vendor directory from composer install
     */
    public function addArgument($argument)
    {
        $this->arguments[] = $argument;

        return $this;
    }

    /**
<<<<<<< HEAD
     * Replaces a specific argument.
     *
     * @param int|string $index
     * @param mixed      $argument
     *
     * @return $this
=======
     * Sets a specific argument.
     *
     * @param int   $index
     * @param mixed $argument
     *
     * @return Definition The current instance
>>>>>>> web and vendor directory from composer install
     *
     * @throws OutOfBoundsException When the replaced argument does not exist
     */
    public function replaceArgument($index, $argument)
    {
<<<<<<< HEAD
        if (0 === count($this->arguments)) {
            throw new OutOfBoundsException('Cannot replace arguments if none have been configured yet.');
        }

        if (is_int($index) && ($index < 0 || $index > count($this->arguments) - 1)) {
            throw new OutOfBoundsException(sprintf('The index "%d" is not in the range [0, %d].', $index, count($this->arguments) - 1));
        }

        if (!array_key_exists($index, $this->arguments)) {
            throw new OutOfBoundsException(sprintf('The argument "%s" doesn\'t exist.', $index));
        }

=======
        if ($index < 0 || $index > count($this->arguments) - 1) {
            throw new OutOfBoundsException(sprintf('The index "%d" is not in the range [0, %d].', $index, count($this->arguments) - 1));
        }

>>>>>>> web and vendor directory from composer install
        $this->arguments[$index] = $argument;

        return $this;
    }

    /**
<<<<<<< HEAD
     * Sets a specific argument.
     *
     * @param int|string $key
     * @param mixed      $value
     *
     * @return $this
     */
    public function setArgument($key, $value)
    {
        $this->arguments[$key] = $value;

        return $this;
    }

    /**
=======
>>>>>>> web and vendor directory from composer install
     * Gets the arguments to pass to the service constructor/factory method.
     *
     * @return array The array of arguments
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Gets an argument to pass to the service constructor/factory method.
     *
<<<<<<< HEAD
     * @param int|string $index
=======
     * @param int $index
>>>>>>> web and vendor directory from composer install
     *
     * @return mixed The argument value
     *
     * @throws OutOfBoundsException When the argument does not exist
     */
    public function getArgument($index)
    {
<<<<<<< HEAD
        if (!array_key_exists($index, $this->arguments)) {
            throw new OutOfBoundsException(sprintf('The argument "%s" doesn\'t exist.', $index));
=======
        if ($index < 0 || $index > count($this->arguments) - 1) {
            throw new OutOfBoundsException(sprintf('The index "%d" is not in the range [0, %d].', $index, count($this->arguments) - 1));
>>>>>>> web and vendor directory from composer install
        }

        return $this->arguments[$index];
    }

    /**
     * Sets the methods to call after service initialization.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @param array $calls An array of method calls
     *
     * @return Definition The current instance
>>>>>>> web and vendor directory from composer install
     */
    public function setMethodCalls(array $calls = array())
    {
        $this->calls = array();
        foreach ($calls as $call) {
            $this->addMethodCall($call[0], $call[1]);
        }

        return $this;
    }

    /**
     * Adds a method to call after service initialization.
     *
     * @param string $method    The method name to call
     * @param array  $arguments An array of arguments to pass to the method call
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return Definition The current instance
>>>>>>> web and vendor directory from composer install
     *
     * @throws InvalidArgumentException on empty $method param
     */
    public function addMethodCall($method, array $arguments = array())
    {
        if (empty($method)) {
<<<<<<< HEAD
            throw new InvalidArgumentException('Method name cannot be empty.');
=======
            throw new InvalidArgumentException(sprintf('Method name cannot be empty.'));
>>>>>>> web and vendor directory from composer install
        }
        $this->calls[] = array($method, $arguments);

        return $this;
    }

    /**
     * Removes a method to call after service initialization.
     *
     * @param string $method The method name to remove
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return Definition The current instance
>>>>>>> web and vendor directory from composer install
     */
    public function removeMethodCall($method)
    {
        foreach ($this->calls as $i => $call) {
            if ($call[0] === $method) {
                unset($this->calls[$i]);
                break;
            }
        }

        return $this;
    }

    /**
     * Check if the current definition has a given method to call after service initialization.
     *
     * @param string $method The method name to search for
     *
     * @return bool
     */
    public function hasMethodCall($method)
    {
        foreach ($this->calls as $call) {
            if ($call[0] === $method) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets the methods to call after service initialization.
     *
     * @return array An array of method calls
     */
    public function getMethodCalls()
    {
        return $this->calls;
    }

    /**
<<<<<<< HEAD
     * Sets the definition templates to conditionally apply on the current definition, keyed by parent interface/class.
     *
     * @param $instanceof ChildDefinition[]
     *
     * @return $this
     */
    public function setInstanceofConditionals(array $instanceof)
    {
        $this->instanceof = $instanceof;

        return $this;
    }

    /**
     * Gets the definition templates to conditionally apply on the current definition, keyed by parent interface/class.
     *
     * @return ChildDefinition[]
     */
    public function getInstanceofConditionals()
    {
        return $this->instanceof;
    }

    /**
     * Sets whether or not instanceof conditionals should be prepended with a global set.
     *
     * @param bool $autoconfigured
     *
     * @return $this
     */
    public function setAutoconfigured($autoconfigured)
    {
        $this->changes['autoconfigured'] = true;

        $this->autoconfigured = $autoconfigured;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoconfigured()
    {
        return $this->autoconfigured;
    }

    /**
     * Sets tags for this definition.
     *
     * @return $this
=======
     * Sets tags for this definition.
     *
     * @param array $tags
     *
     * @return Definition the current instance
>>>>>>> web and vendor directory from composer install
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Returns all tags.
     *
     * @return array An array of tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Gets a tag by name.
     *
     * @param string $name The tag name
     *
     * @return array An array of attributes
     */
    public function getTag($name)
    {
        return isset($this->tags[$name]) ? $this->tags[$name] : array();
    }

    /**
     * Adds a tag for this definition.
     *
     * @param string $name       The tag name
     * @param array  $attributes An array of attributes
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return Definition The current instance
>>>>>>> web and vendor directory from composer install
     */
    public function addTag($name, array $attributes = array())
    {
        $this->tags[$name][] = $attributes;

        return $this;
    }

    /**
     * Whether this definition has a tag with the given name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasTag($name)
    {
        return isset($this->tags[$name]);
    }

    /**
     * Clears all tags for a given name.
     *
     * @param string $name The tag name
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return Definition
>>>>>>> web and vendor directory from composer install
     */
    public function clearTag($name)
    {
        unset($this->tags[$name]);

        return $this;
    }

    /**
     * Clears the tags for this definition.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return Definition The current instance
>>>>>>> web and vendor directory from composer install
     */
    public function clearTags()
    {
        $this->tags = array();

        return $this;
    }

    /**
     * Sets a file to require before creating the service.
     *
     * @param string $file A full pathname to include
     *
<<<<<<< HEAD
     * @return $this
     */
    public function setFile($file)
    {
        $this->changes['file'] = true;

=======
     * @return Definition The current instance
     */
    public function setFile($file)
    {
>>>>>>> web and vendor directory from composer install
        $this->file = $file;

        return $this;
    }

    /**
     * Gets the file to require before creating the service.
     *
     * @return string|null The full pathname to include
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets if the service must be shared or not.
     *
     * @param bool $shared Whether the service must be shared or not
     *
<<<<<<< HEAD
     * @return $this
     */
    public function setShared($shared)
    {
        $this->changes['shared'] = true;

=======
     * @return Definition The current instance
     */
    public function setShared($shared)
    {
>>>>>>> web and vendor directory from composer install
        $this->shared = (bool) $shared;

        return $this;
    }

    /**
     * Whether this service is shared.
     *
     * @return bool
     */
    public function isShared()
    {
        return $this->shared;
    }

    /**
<<<<<<< HEAD
=======
     * Sets the scope of the service.
     *
     * @param string $scope Whether the service must be shared or not
     *
     * @return Definition The current instance
     *
     * @deprecated since version 2.8, to be removed in 3.0.
     */
    public function setScope($scope, $triggerDeprecationError = true)
    {
        if ($triggerDeprecationError) {
            @trigger_error('The '.__METHOD__.' method is deprecated since version 2.8 and will be removed in 3.0.', E_USER_DEPRECATED);
        }

        if (ContainerInterface::SCOPE_PROTOTYPE === $scope) {
            $this->setShared(false);
        }

        $this->scope = $scope;

        return $this;
    }

    /**
     * Returns the scope of the service.
     *
     * @return string
     *
     * @deprecated since version 2.8, to be removed in 3.0.
     */
    public function getScope($triggerDeprecationError = true)
    {
        if ($triggerDeprecationError) {
            @trigger_error('The '.__METHOD__.' method is deprecated since version 2.8 and will be removed in 3.0.', E_USER_DEPRECATED);
        }

        return $this->scope;
    }

    /**
>>>>>>> web and vendor directory from composer install
     * Sets the visibility of this service.
     *
     * @param bool $boolean
     *
<<<<<<< HEAD
     * @return $this
     */
    public function setPublic($boolean)
    {
        $this->changes['public'] = true;

        $this->public = (bool) $boolean;
        $this->private = false;
=======
     * @return Definition The current instance
     */
    public function setPublic($boolean)
    {
        $this->public = (bool) $boolean;
>>>>>>> web and vendor directory from composer install

        return $this;
    }

    /**
     * Whether this service is public facing.
     *
     * @return bool
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
<<<<<<< HEAD
     * Sets if this service is private.
     *
     * When set, the "private" state has a higher precedence than "public".
     * In version 3.4, a "private" service always remains publicly accessible,
     * but triggers a deprecation notice when accessed from the container,
     * so that the service can be made really private in 4.0.
     *
     * @param bool $boolean
     *
     * @return $this
     */
    public function setPrivate($boolean)
    {
        $this->private = (bool) $boolean;
=======
     * Sets the synchronized flag of this service.
     *
     * @param bool $boolean
     *
     * @return Definition The current instance
     *
     * @deprecated since version 2.7, will be removed in 3.0.
     */
    public function setSynchronized($boolean, $triggerDeprecationError = true)
    {
        if ($triggerDeprecationError) {
            @trigger_error('The '.__METHOD__.' method is deprecated since version 2.7 and will be removed in 3.0.', E_USER_DEPRECATED);
        }

        $this->synchronized = (bool) $boolean;
>>>>>>> web and vendor directory from composer install

        return $this;
    }

    /**
<<<<<<< HEAD
     * Whether this service is private.
     *
     * @return bool
     */
    public function isPrivate()
    {
        return $this->private;
=======
     * Whether this service is synchronized.
     *
     * @return bool
     *
     * @deprecated since version 2.7, will be removed in 3.0.
     */
    public function isSynchronized($triggerDeprecationError = true)
    {
        if ($triggerDeprecationError) {
            @trigger_error('The '.__METHOD__.' method is deprecated since version 2.7 and will be removed in 3.0.', E_USER_DEPRECATED);
        }

        return $this->synchronized;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Sets the lazy flag of this service.
     *
     * @param bool $lazy
     *
<<<<<<< HEAD
     * @return $this
     */
    public function setLazy($lazy)
    {
        $this->changes['lazy'] = true;

=======
     * @return Definition The current instance
     */
    public function setLazy($lazy)
    {
>>>>>>> web and vendor directory from composer install
        $this->lazy = (bool) $lazy;

        return $this;
    }

    /**
     * Whether this service is lazy.
     *
     * @return bool
     */
    public function isLazy()
    {
        return $this->lazy;
    }

    /**
     * Sets whether this definition is synthetic, that is not constructed by the
     * container, but dynamically injected.
     *
     * @param bool $boolean
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return Definition the current instance
>>>>>>> web and vendor directory from composer install
     */
    public function setSynthetic($boolean)
    {
        $this->synthetic = (bool) $boolean;

        return $this;
    }

    /**
     * Whether this definition is synthetic, that is not constructed by the
     * container, but dynamically injected.
     *
     * @return bool
     */
    public function isSynthetic()
    {
        return $this->synthetic;
    }

    /**
     * Whether this definition is abstract, that means it merely serves as a
     * template for other definitions.
     *
     * @param bool $boolean
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return Definition the current instance
>>>>>>> web and vendor directory from composer install
     */
    public function setAbstract($boolean)
    {
        $this->abstract = (bool) $boolean;

        return $this;
    }

    /**
     * Whether this definition is abstract, that means it merely serves as a
     * template for other definitions.
     *
     * @return bool
     */
    public function isAbstract()
    {
        return $this->abstract;
    }

    /**
     * Whether this definition is deprecated, that means it should not be called
     * anymore.
     *
     * @param bool   $status
     * @param string $template Template message to use if the definition is deprecated
     *
<<<<<<< HEAD
     * @return $this
     *
     * @throws InvalidArgumentException when the message template is invalid
=======
     * @return Definition the current instance
     *
     * @throws InvalidArgumentException When the message template is invalid.
>>>>>>> web and vendor directory from composer install
     */
    public function setDeprecated($status = true, $template = null)
    {
        if (null !== $template) {
            if (preg_match('#[\r\n]|\*/#', $template)) {
                throw new InvalidArgumentException('Invalid characters found in deprecation template.');
            }

            if (false === strpos($template, '%service_id%')) {
                throw new InvalidArgumentException('The deprecation template must contain the "%service_id%" placeholder.');
            }

            $this->deprecationTemplate = $template;
        }

<<<<<<< HEAD
        $this->changes['deprecated'] = true;

=======
>>>>>>> web and vendor directory from composer install
        $this->deprecated = (bool) $status;

        return $this;
    }

    /**
     * Whether this definition is deprecated, that means it should not be called
     * anymore.
     *
     * @return bool
     */
    public function isDeprecated()
    {
        return $this->deprecated;
    }

    /**
     * Message to use if this definition is deprecated.
     *
     * @param string $id Service id relying on this definition
     *
     * @return string
     */
    public function getDeprecationMessage($id)
    {
<<<<<<< HEAD
        return str_replace('%service_id%', $id, $this->deprecationTemplate ?: self::$defaultDeprecationTemplate);
=======
        return str_replace('%service_id%', $id, $this->deprecationTemplate);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Sets a configurator to call after the service is fully initialized.
     *
<<<<<<< HEAD
     * @param string|array $configurator A PHP callable
     *
     * @return $this
     */
    public function setConfigurator($configurator)
    {
        $this->changes['configurator'] = true;

        if (is_string($configurator) && false !== strpos($configurator, '::')) {
            $configurator = explode('::', $configurator, 2);
        }

        $this->configurator = $configurator;
=======
     * @param callable $callable A PHP callable
     *
     * @return Definition The current instance
     */
    public function setConfigurator($callable)
    {
        $this->configurator = $callable;
>>>>>>> web and vendor directory from composer install

        return $this;
    }

    /**
     * Gets the configurator to call after the service is fully initialized.
     *
     * @return callable|null The PHP callable to call
     */
    public function getConfigurator()
    {
        return $this->configurator;
    }

    /**
     * Sets types that will default to this definition.
     *
     * @param string[] $types
     *
<<<<<<< HEAD
     * @return $this
     *
     * @deprecated since version 3.3, to be removed in 4.0.
     */
    public function setAutowiringTypes(array $types)
    {
        @trigger_error('Autowiring-types are deprecated since Symfony 3.3 and will be removed in 4.0. Use aliases instead.', E_USER_DEPRECATED);

=======
     * @return Definition The current instance
     */
    public function setAutowiringTypes(array $types)
    {
>>>>>>> web and vendor directory from composer install
        $this->autowiringTypes = array();

        foreach ($types as $type) {
            $this->autowiringTypes[$type] = true;
        }

        return $this;
    }

    /**
     * Is the definition autowired?
     *
     * @return bool
     */
    public function isAutowired()
    {
        return $this->autowired;
    }

    /**
<<<<<<< HEAD
     * Enables/disables autowiring.
     *
     * @param bool $autowired
     *
     * @return $this
     */
    public function setAutowired($autowired)
    {
        $this->changes['autowired'] = true;

        $this->autowired = (bool) $autowired;
=======
     * Sets autowired.
     *
     * @param bool $autowired
     *
     * @return Definition The current instance
     */
    public function setAutowired($autowired)
    {
        $this->autowired = $autowired;
>>>>>>> web and vendor directory from composer install

        return $this;
    }

    /**
     * Gets autowiring types that will default to this definition.
     *
     * @return string[]
<<<<<<< HEAD
     *
     * @deprecated since version 3.3, to be removed in 4.0.
     */
    public function getAutowiringTypes(/*$triggerDeprecation = true*/)
    {
        if (1 > func_num_args() || func_get_arg(0)) {
            @trigger_error('Autowiring-types are deprecated since Symfony 3.3 and will be removed in 4.0. Use aliases instead.', E_USER_DEPRECATED);
        }

=======
     */
    public function getAutowiringTypes()
    {
>>>>>>> web and vendor directory from composer install
        return array_keys($this->autowiringTypes);
    }

    /**
     * Adds a type that will default to this definition.
     *
     * @param string $type
     *
<<<<<<< HEAD
     * @return $this
     *
     * @deprecated since version 3.3, to be removed in 4.0.
     */
    public function addAutowiringType($type)
    {
        @trigger_error(sprintf('Autowiring-types are deprecated since Symfony 3.3 and will be removed in 4.0. Use aliases instead for "%s".', $type), E_USER_DEPRECATED);

=======
     * @return Definition The current instance
     */
    public function addAutowiringType($type)
    {
>>>>>>> web and vendor directory from composer install
        $this->autowiringTypes[$type] = true;

        return $this;
    }

    /**
     * Removes a type.
     *
     * @param string $type
     *
<<<<<<< HEAD
     * @return $this
     *
     * @deprecated since version 3.3, to be removed in 4.0.
     */
    public function removeAutowiringType($type)
    {
        @trigger_error(sprintf('Autowiring-types are deprecated since Symfony 3.3 and will be removed in 4.0. Use aliases instead for "%s".', $type), E_USER_DEPRECATED);

=======
     * @return Definition The current instance
     */
    public function removeAutowiringType($type)
    {
>>>>>>> web and vendor directory from composer install
        unset($this->autowiringTypes[$type]);

        return $this;
    }

    /**
     * Will this definition default for the given type?
     *
     * @param string $type
     *
     * @return bool
<<<<<<< HEAD
     *
     * @deprecated since version 3.3, to be removed in 4.0.
     */
    public function hasAutowiringType($type)
    {
        @trigger_error(sprintf('Autowiring-types are deprecated since Symfony 3.3 and will be removed in 4.0. Use aliases instead for "%s".', $type), E_USER_DEPRECATED);

        return isset($this->autowiringTypes[$type]);
    }

    /**
     * Gets bindings.
     *
     * @return array
     */
    public function getBindings()
    {
        return $this->bindings;
    }

    /**
     * Sets bindings.
     *
     * Bindings map $named or FQCN arguments to values that should be
     * injected in the matching parameters (of the constructor, of methods
     * called and of controller actions).
     *
     * @param array $bindings
     *
     * @return $this
     */
    public function setBindings(array $bindings)
    {
        foreach ($bindings as $key => $binding) {
            if (!$binding instanceof BoundArgument) {
                $bindings[$key] = new BoundArgument($binding);
            }
        }

        $this->bindings = $bindings;

        return $this;
    }

    /**
     * Add an error that occurred when building this Definition.
     *
     * @param string $error
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * Returns any errors that occurred while building this Definition.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
=======
     */
    public function hasAutowiringType($type)
    {
        return isset($this->autowiringTypes[$type]);
    }
>>>>>>> web and vendor directory from composer install
}
