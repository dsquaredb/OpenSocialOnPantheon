<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Compiler;

<<<<<<< HEAD
use Symfony\Component\Config\Resource\ClassExistenceResource;
use Symfony\Component\DependencyInjection\Config\AutowireServiceResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\AutowiringFailedException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\LazyProxy\ProxyHelper;
use Symfony\Component\DependencyInjection\TypedReference;

/**
 * Inspects existing service definitions and wires the autowired ones using the type hints of their classes.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @author Nicolas Grekas <p@tchwork.com>
 */
class AutowirePass extends AbstractRecursivePass
{
    private $definedTypes = array();
    private $types;
    private $ambiguousServiceTypes;
    private $autowired = array();
    private $lastFailure;
    private $throwOnAutowiringException;
    private $autowiringExceptions = array();
    private $strictMode;

    /**
     * @param bool $throwOnAutowireException Errors can be retrieved via Definition::getErrors()
     */
    public function __construct($throwOnAutowireException = true)
    {
        $this->throwOnAutowiringException = $throwOnAutowireException;
    }

    /**
     * @deprecated since version 3.4, to be removed in 4.0.
     *
     * @return AutowiringFailedException[]
     */
    public function getAutowiringExceptions()
    {
        @trigger_error('Calling AutowirePass::getAutowiringExceptions() is deprecated since Symfony 3.4 and will be removed in 4.0. Use Definition::getErrors() instead.', E_USER_DEPRECATED);

        return $this->autowiringExceptions;
    }
=======
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Guesses constructor arguments of services definitions and try to instantiate services if necessary.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class AutowirePass implements CompilerPassInterface
{
    private $container;
    private $reflectionClasses = array();
    private $definedTypes = array();
    private $types;
    private $notGuessableTypes = array();
>>>>>>> web and vendor directory from composer install

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
<<<<<<< HEAD
        // clear out any possibly stored exceptions from before
        $this->autowiringExceptions = array();
        $this->strictMode = $container->hasParameter('container.autowiring.strict_mode') && $container->getParameter('container.autowiring.strict_mode');

        try {
            parent::process($container);
        } finally {
            $this->definedTypes = array();
            $this->types = null;
            $this->ambiguousServiceTypes = null;
            $this->autowired = array();
        }
    }

    /**
     * Creates a resource to help know if this service has changed.
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return AutowireServiceResource
     *
     * @deprecated since version 3.3, to be removed in 4.0. Use ContainerBuilder::getReflectionClass() instead.
     */
    public static function createResourceForClass(\ReflectionClass $reflectionClass)
    {
        @trigger_error('The '.__METHOD__.'() method is deprecated since Symfony 3.3 and will be removed in 4.0. Use ContainerBuilder::getReflectionClass() instead.', E_USER_DEPRECATED);

        $metadata = array();

        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            if (!$reflectionMethod->isStatic()) {
                $metadata[$reflectionMethod->name] = self::getResourceMetadataForMethod($reflectionMethod);
            }
        }

        return new AutowireServiceResource($reflectionClass->name, $reflectionClass->getFileName(), $metadata);
    }

    /**
     * {@inheritdoc}
     */
    protected function processValue($value, $isRoot = false)
    {
        try {
            return $this->doProcessValue($value, $isRoot);
        } catch (AutowiringFailedException $e) {
            if ($this->throwOnAutowiringException) {
                throw $e;
            }

            $this->autowiringExceptions[] = $e;
            $this->container->getDefinition($this->currentId)->addError($e->getMessage());

            return parent::processValue($value, $isRoot);
        }
    }

    private function doProcessValue($value, $isRoot = false)
    {
        if ($value instanceof TypedReference) {
            if ($ref = $this->getAutowiredReference($value, $value->getRequiringClass() ? sprintf('for "%s" in "%s"', $value->getType(), $value->getRequiringClass()) : '')) {
                return $ref;
            }
            $this->container->log($this, $this->createTypeNotFoundMessage($value, 'it'));
        }
        $value = parent::processValue($value, $isRoot);

        if (!$value instanceof Definition || !$value->isAutowired() || $value->isAbstract() || !$value->getClass()) {
            return $value;
        }
        if (!$reflectionClass = $this->container->getReflectionClass($value->getClass(), false)) {
            $this->container->log($this, sprintf('Skipping service "%s": Class or interface "%s" cannot be loaded.', $this->currentId, $value->getClass()));

            return $value;
        }

        $methodCalls = $value->getMethodCalls();

        try {
            $constructor = $this->getConstructor($value, false);
        } catch (RuntimeException $e) {
            throw new AutowiringFailedException($this->currentId, $e->getMessage(), 0, $e);
        }

        if ($constructor) {
            array_unshift($methodCalls, array($constructor, $value->getArguments()));
        }

        $methodCalls = $this->autowireCalls($reflectionClass, $methodCalls);

        if ($constructor) {
            list(, $arguments) = array_shift($methodCalls);

            if ($arguments !== $value->getArguments()) {
                $value->setArguments($arguments);
            }
        }

        if ($methodCalls !== $value->getMethodCalls()) {
            $value->setMethodCalls($methodCalls);
        }

        return $value;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @param array            $methodCalls
     *
     * @return array
     */
    private function autowireCalls(\ReflectionClass $reflectionClass, array $methodCalls)
    {
        foreach ($methodCalls as $i => $call) {
            list($method, $arguments) = $call;

            if ($method instanceof \ReflectionFunctionAbstract) {
                $reflectionMethod = $method;
            } else {
                $reflectionMethod = $this->getReflectionMethod(new Definition($reflectionClass->name), $method);
            }

            $arguments = $this->autowireMethod($reflectionMethod, $arguments);

            if ($arguments !== $call[1]) {
                $methodCalls[$i][1] = $arguments;
            }
        }

        return $methodCalls;
    }

    /**
     * Autowires the constructor or a method.
     *
     * @param \ReflectionFunctionAbstract $reflectionMethod
     * @param array                       $arguments
     *
     * @return array The autowired arguments
     *
     * @throws AutowiringFailedException
     */
    private function autowireMethod(\ReflectionFunctionAbstract $reflectionMethod, array $arguments)
    {
        $class = $reflectionMethod instanceof \ReflectionMethod ? $reflectionMethod->class : $this->currentId;
        $method = $reflectionMethod->name;
        $parameters = $reflectionMethod->getParameters();
        if (method_exists('ReflectionMethod', 'isVariadic') && $reflectionMethod->isVariadic()) {
            array_pop($parameters);
        }

        foreach ($parameters as $index => $parameter) {
=======
        $throwingAutoloader = function ($class) { throw new \ReflectionException(sprintf('Class %s does not exist', $class)); };
        spl_autoload_register($throwingAutoloader);

        try {
            $this->container = $container;
            foreach ($container->getDefinitions() as $id => $definition) {
                if ($definition->isAutowired()) {
                    $this->completeDefinition($id, $definition);
                }
            }
        } catch (\Exception $e) {
        } catch (\Throwable $e) {
        }

        spl_autoload_unregister($throwingAutoloader);

        // Free memory and remove circular reference to container
        $this->container = null;
        $this->reflectionClasses = array();
        $this->definedTypes = array();
        $this->types = null;
        $this->notGuessableTypes = array();

        if (isset($e)) {
            throw $e;
        }
    }

    /**
     * Wires the given definition.
     *
     * @param string     $id
     * @param Definition $definition
     *
     * @throws RuntimeException
     */
    private function completeDefinition($id, Definition $definition)
    {
        if (!$reflectionClass = $this->getReflectionClass($id, $definition)) {
            return;
        }

        $this->container->addClassResource($reflectionClass);

        if (!$constructor = $reflectionClass->getConstructor()) {
            return;
        }

        $arguments = $definition->getArguments();
        foreach ($constructor->getParameters() as $index => $parameter) {
>>>>>>> web and vendor directory from composer install
            if (array_key_exists($index, $arguments) && '' !== $arguments[$index]) {
                continue;
            }

<<<<<<< HEAD
            $type = ProxyHelper::getTypeHint($reflectionMethod, $parameter, true);

            if (!$type) {
                if (isset($arguments[$index])) {
                    continue;
                }

                // no default value? Then fail
                if (!$parameter->isDefaultValueAvailable()) {
                    // For core classes, isDefaultValueAvailable() can
                    // be false when isOptional() returns true. If the
                    // argument *is* optional, allow it to be missing
                    if ($parameter->isOptional()) {
                        continue;
                    }
                    $type = ProxyHelper::getTypeHint($reflectionMethod, $parameter, false);
                    $type = $type ? sprintf('is type-hinted "%s"', $type) : 'has no type-hint';

                    throw new AutowiringFailedException($this->currentId, sprintf('Cannot autowire service "%s": argument "$%s" of method "%s()" %s, you should configure its value explicitly.', $this->currentId, $parameter->name, $class !== $this->currentId ? $class.'::'.$method : $method, $type));
                }

                // specifically pass the default value
                $arguments[$index] = $parameter->getDefaultValue();

                continue;
            }

            if (!$value = $this->getAutowiredReference($ref = new TypedReference($type, $type, !$parameter->isOptional() ? $class : ''), 'for '.sprintf('argument "$%s" of method "%s()"', $parameter->name, $class.'::'.$method))) {
                $failureMessage = $this->createTypeNotFoundMessage($ref, sprintf('argument "$%s" of method "%s()"', $parameter->name, $class !== $this->currentId ? $class.'::'.$method : $method));

                if ($parameter->isDefaultValueAvailable()) {
                    $value = $parameter->getDefaultValue();
                } elseif (!$parameter->allowsNull()) {
                    throw new AutowiringFailedException($this->currentId, $failureMessage);
                }
                $this->container->log($this, $failureMessage);
=======
            try {
                if (!$typeHint = $parameter->getClass()) {
                    // no default value? Then fail
                    if (!$parameter->isOptional()) {
                        throw new RuntimeException(sprintf('Unable to autowire argument index %d ($%s) for the service "%s". If this is an object, give it a type-hint. Otherwise, specify this argument\'s value explicitly.', $index, $parameter->name, $id));
                    }

                    // specifically pass the default value
                    $arguments[$index] = $parameter->getDefaultValue();

                    continue;
                }

                if (null === $this->types) {
                    $this->populateAvailableTypes();
                }

                if (isset($this->types[$typeHint->name]) && !isset($this->notGuessableTypes[$typeHint->name])) {
                    $value = new Reference($this->types[$typeHint->name]);
                } else {
                    try {
                        $value = $this->createAutowiredDefinition($typeHint, $id);
                    } catch (RuntimeException $e) {
                        if ($parameter->allowsNull()) {
                            $value = null;
                        } elseif ($parameter->isDefaultValueAvailable()) {
                            $value = $parameter->getDefaultValue();
                        } else {
                            throw $e;
                        }
                    }
                }
            } catch (\ReflectionException $e) {
                // Typehint against a non-existing class

                if (!$parameter->isDefaultValueAvailable()) {
                    throw new RuntimeException(sprintf('Cannot autowire argument %s for %s because the type-hinted class does not exist (%s).', $index + 1, $definition->getClass(), $e->getMessage()), 0, $e);
                }

                $value = $parameter->getDefaultValue();
>>>>>>> web and vendor directory from composer install
            }

            $arguments[$index] = $value;
        }

<<<<<<< HEAD
        if ($parameters && !isset($arguments[++$index])) {
            while (0 <= --$index) {
                $parameter = $parameters[$index];
                if (!$parameter->isDefaultValueAvailable() || $parameter->getDefaultValue() !== $arguments[$index]) {
                    break;
                }
                unset($arguments[$index]);
            }
        }

        // it's possible index 1 was set, then index 0, then 2, etc
        // make sure that we re-order so they're injected as expected
        ksort($arguments);

        return $arguments;
    }

    /**
     * @return TypedReference|null A reference to the service matching the given type, if any
     */
    private function getAutowiredReference(TypedReference $reference, $deprecationMessage)
    {
        $this->lastFailure = null;
        $type = $reference->getType();

        if ($type !== $this->container->normalizeId($reference) || ($this->container->has($type) && !$this->container->findDefinition($type)->isAbstract())) {
            return $reference;
        }

        if (null === $this->types) {
            $this->populateAvailableTypes($this->strictMode);
        }

        if (isset($this->definedTypes[$type])) {
            return new TypedReference($this->types[$type], $type);
        }

        if (!$this->strictMode && isset($this->types[$type])) {
            $message = 'Autowiring services based on the types they implement is deprecated since Symfony 3.3 and won\'t be supported in version 4.0.';
            if ($aliasSuggestion = $this->getAliasesSuggestionForType($type = $reference->getType(), $deprecationMessage)) {
                $message .= ' '.$aliasSuggestion;
            } else {
                $message .= sprintf(' You should %s the "%s" service to "%s" instead.', isset($this->types[$this->types[$type]]) ? 'alias' : 'rename (or alias)', $this->types[$type], $type);
            }

            @trigger_error($message, E_USER_DEPRECATED);

            return new TypedReference($this->types[$type], $type);
        }

        if (!$reference->canBeAutoregistered() || isset($this->types[$type]) || isset($this->ambiguousServiceTypes[$type])) {
            return;
        }

        if (isset($this->autowired[$type])) {
            return $this->autowired[$type] ? new TypedReference($this->autowired[$type], $type) : null;
        }

        if (!$this->strictMode) {
            return $this->createAutowiredDefinition($type);
        }
=======
        // it's possible index 1 was set, then index 0, then 2, etc
        // make sure that we re-order so they're injected as expected
        ksort($arguments);
        $definition->setArguments($arguments);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Populates the list of available types.
     */
<<<<<<< HEAD
    private function populateAvailableTypes($onlyAutowiringTypes = false)
    {
        $this->types = array();
        if (!$onlyAutowiringTypes) {
            $this->ambiguousServiceTypes = array();
        }

        foreach ($this->container->getDefinitions() as $id => $definition) {
            $this->populateAvailableType($id, $definition, $onlyAutowiringTypes);
=======
    private function populateAvailableTypes()
    {
        $this->types = array();

        foreach ($this->container->getDefinitions() as $id => $definition) {
            $this->populateAvailableType($id, $definition);
>>>>>>> web and vendor directory from composer install
        }
    }

    /**
     * Populates the list of available types for a given definition.
     *
     * @param string     $id
     * @param Definition $definition
     */
<<<<<<< HEAD
    private function populateAvailableType($id, Definition $definition, $onlyAutowiringTypes)
=======
    private function populateAvailableType($id, Definition $definition)
>>>>>>> web and vendor directory from composer install
    {
        // Never use abstract services
        if ($definition->isAbstract()) {
            return;
        }

<<<<<<< HEAD
        foreach ($definition->getAutowiringTypes(false) as $type) {
            $this->definedTypes[$type] = true;
            $this->types[$type] = $id;
            unset($this->ambiguousServiceTypes[$type]);
        }

        if ($onlyAutowiringTypes) {
            return;
        }

        if (preg_match('/^\d+_[^~]++~[._a-zA-Z\d]{7}$/', $id) || $definition->isDeprecated() || !$reflectionClass = $this->container->getReflectionClass($definition->getClass(), false)) {
=======
        foreach ($definition->getAutowiringTypes() as $type) {
            $this->definedTypes[$type] = true;
            $this->types[$type] = $id;
        }

        if (!$reflectionClass = $this->getReflectionClass($id, $definition)) {
>>>>>>> web and vendor directory from composer install
            return;
        }

        foreach ($reflectionClass->getInterfaces() as $reflectionInterface) {
            $this->set($reflectionInterface->name, $id);
        }

        do {
            $this->set($reflectionClass->name, $id);
        } while ($reflectionClass = $reflectionClass->getParentClass());
    }

    /**
     * Associates a type and a service id if applicable.
     *
     * @param string $type
     * @param string $id
     */
    private function set($type, $id)
    {
        if (isset($this->definedTypes[$type])) {
            return;
        }

<<<<<<< HEAD
        // is this already a type/class that is known to match multiple services?
        if (isset($this->ambiguousServiceTypes[$type])) {
            $this->ambiguousServiceTypes[$type][] = $id;
=======
        if (!isset($this->types[$type])) {
            $this->types[$type] = $id;
>>>>>>> web and vendor directory from composer install

            return;
        }

<<<<<<< HEAD
        // check to make sure the type doesn't match multiple services
        if (!isset($this->types[$type]) || $this->types[$type] === $id) {
            $this->types[$type] = $id;

            return;
        }

        // keep an array of all services matching this type
        if (!isset($this->ambiguousServiceTypes[$type])) {
            $this->ambiguousServiceTypes[$type] = array($this->types[$type]);
            unset($this->types[$type]);
        }
        $this->ambiguousServiceTypes[$type][] = $id;
=======
        if ($this->types[$type] === $id) {
            return;
        }

        if (!isset($this->notGuessableTypes[$type])) {
            $this->notGuessableTypes[$type] = true;
            $this->types[$type] = (array) $this->types[$type];
        }

        $this->types[$type][] = $id;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Registers a definition for the type if possible or throws an exception.
     *
<<<<<<< HEAD
     * @param string $type
     *
     * @return TypedReference|null A reference to the registered definition
     */
    private function createAutowiredDefinition($type)
    {
        if (!($typeHint = $this->container->getReflectionClass($type, false)) || !$typeHint->isInstantiable()) {
            return;
        }

        $currentId = $this->currentId;
        $this->currentId = $type;
        $this->autowired[$type] = $argumentId = sprintf('autowired.%s', $type);
        $argumentDefinition = new Definition($type);
        $argumentDefinition->setPublic(false);
        $argumentDefinition->setAutowired(true);

        try {
            $originalThrowSetting = $this->throwOnAutowiringException;
            $this->throwOnAutowiringException = true;
            $this->processValue($argumentDefinition, true);
            $this->container->setDefinition($argumentId, $argumentDefinition);
        } catch (AutowiringFailedException $e) {
            $this->autowired[$type] = false;
            $this->lastFailure = $e->getMessage();
            $this->container->log($this, $this->lastFailure);

            return;
        } finally {
            $this->throwOnAutowiringException = $originalThrowSetting;
            $this->currentId = $currentId;
        }

        @trigger_error(sprintf('Relying on service auto-registration for type "%s" is deprecated since Symfony 3.4 and won\'t be supported in 4.0. Create a service named "%s" instead.', $type, $type), E_USER_DEPRECATED);

        $this->container->log($this, sprintf('Type "%s" has been auto-registered for service "%s".', $type, $this->currentId));

        return new TypedReference($argumentId, $type);
    }

    private function createTypeNotFoundMessage(TypedReference $reference, $label)
    {
        if (!$r = $this->container->getReflectionClass($type = $reference->getType(), false)) {
            // either $type does not exist or a parent class does not exist
            try {
                $resource = new ClassExistenceResource($type, false);
                // isFresh() will explode ONLY if a parent class/trait does not exist
                $resource->isFresh(0);
                $parentMsg = false;
            } catch (\ReflectionException $e) {
                $parentMsg = $e->getMessage();
            }

            $message = sprintf('has type "%s" but this class %s.', $type, $parentMsg ? sprintf('is missing a parent class (%s)', $parentMsg) : 'was not found');
        } else {
            $alternatives = $this->createTypeAlternatives($reference);
            $message = $this->container->has($type) ? 'this service is abstract' : 'no such service exists';
            $message = sprintf('references %s "%s" but %s.%s', $r->isInterface() ? 'interface' : 'class', $type, $message, $alternatives);

            if ($r->isInterface() && !$alternatives) {
                $message .= ' Did you create a class that implements this interface?';
            }
        }

        $message = sprintf('Cannot autowire service "%s": %s %s', $this->currentId, $label, $message);

        if (null !== $this->lastFailure) {
            $message = $this->lastFailure."\n".$message;
            $this->lastFailure = null;
        }

        return $message;
    }

    private function createTypeAlternatives(TypedReference $reference)
    {
        // try suggesting available aliases first
        if ($message = $this->getAliasesSuggestionForType($type = $reference->getType())) {
            return ' '.$message;
        }
        if (null === $this->ambiguousServiceTypes) {
            $this->populateAvailableTypes();
        }

        if (isset($this->ambiguousServiceTypes[$type])) {
            $message = sprintf('one of these existing services: "%s"', implode('", "', $this->ambiguousServiceTypes[$type]));
        } elseif (isset($this->types[$type])) {
            $message = sprintf('the existing "%s" service', $this->types[$type]);
        } elseif ($reference->getRequiringClass() && !$reference->canBeAutoregistered() && !$this->strictMode) {
            return ' It cannot be auto-registered because it is from a different root namespace.';
        } else {
            return;
        }

        return sprintf(' You should maybe alias this %s to %s.', class_exists($type, false) ? 'class' : 'interface', $message);
    }

    /**
     * @deprecated since version 3.3, to be removed in 4.0.
     */
    private static function getResourceMetadataForMethod(\ReflectionMethod $method)
    {
        $methodArgumentsMetadata = array();
        foreach ($method->getParameters() as $parameter) {
            try {
                $class = $parameter->getClass();
            } catch (\ReflectionException $e) {
                // type-hint is against a non-existent class
                $class = false;
            }

            $isVariadic = method_exists($parameter, 'isVariadic') && $parameter->isVariadic();
            $methodArgumentsMetadata[] = array(
                'class' => $class,
                'isOptional' => $parameter->isOptional(),
                'defaultValue' => ($parameter->isOptional() && !$isVariadic) ? $parameter->getDefaultValue() : null,
            );
        }

        return $methodArgumentsMetadata;
    }

    private function getAliasesSuggestionForType($type, $extraContext = null)
    {
        $aliases = array();
        foreach (class_parents($type) + class_implements($type) as $parent) {
            if ($this->container->has($parent) && !$this->container->findDefinition($parent)->isAbstract()) {
                $aliases[] = $parent;
            }
        }

        $extraContext = $extraContext ? ' '.$extraContext : '';
        if (1 < $len = count($aliases)) {
            $message = sprintf('Try changing the type-hint%s to one of its parents: ', $extraContext);
            for ($i = 0, --$len; $i < $len; ++$i) {
                $message .= sprintf('%s "%s", ', class_exists($aliases[$i], false) ? 'class' : 'interface', $aliases[$i]);
            }
            $message .= sprintf('or %s "%s".', class_exists($aliases[$i], false) ? 'class' : 'interface', $aliases[$i]);

            return $message;
        }

        if ($aliases) {
            return sprintf('Try changing the type-hint%s to "%s" instead.', $extraContext, $aliases[0]);
        }
=======
     * @param \ReflectionClass $typeHint
     * @param string           $id
     *
     * @return Reference A reference to the registered definition
     *
     * @throws RuntimeException
     */
    private function createAutowiredDefinition(\ReflectionClass $typeHint, $id)
    {
        if (isset($this->notGuessableTypes[$typeHint->name])) {
            $classOrInterface = $typeHint->isInterface() ? 'interface' : 'class';
            $matchingServices = implode(', ', $this->types[$typeHint->name]);

            throw new RuntimeException(sprintf('Unable to autowire argument of type "%s" for the service "%s". Multiple services exist for this %s (%s).', $typeHint->name, $id, $classOrInterface, $matchingServices));
        }

        if (!$typeHint->isInstantiable()) {
            $classOrInterface = $typeHint->isInterface() ? 'interface' : 'class';
            throw new RuntimeException(sprintf('Unable to autowire argument of type "%s" for the service "%s". No services were found matching this %s and it cannot be auto-registered.', $typeHint->name, $id, $classOrInterface));
        }

        $argumentId = sprintf('autowired.%s', $typeHint->name);

        $argumentDefinition = $this->container->register($argumentId, $typeHint->name);
        $argumentDefinition->setPublic(false);

        $this->populateAvailableType($argumentId, $argumentDefinition);

        try {
            $this->completeDefinition($argumentId, $argumentDefinition);
        } catch (RuntimeException $e) {
            $classOrInterface = $typeHint->isInterface() ? 'interface' : 'class';
            $message = sprintf('Unable to autowire argument of type "%s" for the service "%s". No services were found matching this %s and it cannot be auto-registered.', $typeHint->name, $id, $classOrInterface);
            throw new RuntimeException($message, 0, $e);
        }

        return new Reference($argumentId);
    }

    /**
     * Retrieves the reflection class associated with the given service.
     *
     * @param string     $id
     * @param Definition $definition
     *
     * @return \ReflectionClass|false
     */
    private function getReflectionClass($id, Definition $definition)
    {
        if (isset($this->reflectionClasses[$id])) {
            return $this->reflectionClasses[$id];
        }

        // Cannot use reflection if the class isn't set
        if (!$class = $definition->getClass()) {
            return false;
        }

        $class = $this->container->getParameterBag()->resolveValue($class);

        try {
            $reflector = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            $reflector = false;
        }

        return $this->reflectionClasses[$id] = $reflector;
>>>>>>> web and vendor directory from composer install
    }
}
