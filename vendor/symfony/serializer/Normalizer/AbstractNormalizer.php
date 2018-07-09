<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer\Normalizer;

use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\Mapping\AttributeMetadataInterface;
<<<<<<< HEAD
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
=======
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
>>>>>>> web and vendor directory from composer install

/**
 * Normalizer implementation.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
<<<<<<< HEAD
abstract class AbstractNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    use ObjectToPopulateTrait;

    const CIRCULAR_REFERENCE_LIMIT = 'circular_reference_limit';
    const OBJECT_TO_POPULATE = 'object_to_populate';
    const GROUPS = 'groups';
    const ATTRIBUTES = 'attributes';
    const ALLOW_EXTRA_ATTRIBUTES = 'allow_extra_attributes';
=======
abstract class AbstractNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface
{
    const CIRCULAR_REFERENCE_LIMIT = 'circular_reference_limit';
    const OBJECT_TO_POPULATE = 'object_to_populate';
    const GROUPS = 'groups';
>>>>>>> web and vendor directory from composer install

    /**
     * @var int
     */
    protected $circularReferenceLimit = 1;

    /**
     * @var callable
     */
    protected $circularReferenceHandler;

    /**
     * @var ClassMetadataFactoryInterface|null
     */
    protected $classMetadataFactory;

    /**
     * @var NameConverterInterface|null
     */
    protected $nameConverter;

    /**
     * @var array
     */
    protected $callbacks = array();

    /**
     * @var array
     */
    protected $ignoredAttributes = array();

    /**
     * @var array
     */
    protected $camelizedAttributes = array();

    /**
     * Sets the {@link ClassMetadataFactoryInterface} to use.
<<<<<<< HEAD
=======
     *
     * @param ClassMetadataFactoryInterface|null $classMetadataFactory
     * @param NameConverterInterface|null        $nameConverter
>>>>>>> web and vendor directory from composer install
     */
    public function __construct(ClassMetadataFactoryInterface $classMetadataFactory = null, NameConverterInterface $nameConverter = null)
    {
        $this->classMetadataFactory = $classMetadataFactory;
        $this->nameConverter = $nameConverter;
    }

    /**
     * Set circular reference limit.
     *
<<<<<<< HEAD
     * @param int $circularReferenceLimit Limit of iterations for the same object
=======
     * @param int $circularReferenceLimit limit of iterations for the same object
>>>>>>> web and vendor directory from composer install
     *
     * @return self
     */
    public function setCircularReferenceLimit($circularReferenceLimit)
    {
        $this->circularReferenceLimit = $circularReferenceLimit;

        return $this;
    }

    /**
     * Set circular reference handler.
     *
     * @param callable $circularReferenceHandler
     *
     * @return self
<<<<<<< HEAD
     */
    public function setCircularReferenceHandler(callable $circularReferenceHandler)
    {
=======
     *
     * @throws InvalidArgumentException
     */
    public function setCircularReferenceHandler($circularReferenceHandler)
    {
        if (!is_callable($circularReferenceHandler)) {
            throw new InvalidArgumentException('The given circular reference handler is not callable.');
        }

>>>>>>> web and vendor directory from composer install
        $this->circularReferenceHandler = $circularReferenceHandler;

        return $this;
    }

    /**
     * Set normalization callbacks.
     *
<<<<<<< HEAD
     * @param callable[] $callbacks Help normalize the result
=======
     * @param callable[] $callbacks help normalize the result
>>>>>>> web and vendor directory from composer install
     *
     * @return self
     *
     * @throws InvalidArgumentException if a non-callable callback is set
     */
    public function setCallbacks(array $callbacks)
    {
        foreach ($callbacks as $attribute => $callback) {
<<<<<<< HEAD
            if (!\is_callable($callback)) {
=======
            if (!is_callable($callback)) {
>>>>>>> web and vendor directory from composer install
                throw new InvalidArgumentException(sprintf(
                    'The given callback for attribute "%s" is not callable.',
                    $attribute
                ));
            }
        }
        $this->callbacks = $callbacks;

        return $this;
    }

    /**
     * Set ignored attributes for normalization and denormalization.
     *
<<<<<<< HEAD
=======
     * @param array $ignoredAttributes
     *
>>>>>>> web and vendor directory from composer install
     * @return self
     */
    public function setIgnoredAttributes(array $ignoredAttributes)
    {
        $this->ignoredAttributes = $ignoredAttributes;

        return $this;
    }

    /**
<<<<<<< HEAD
=======
     * Set attributes to be camelized on denormalize.
     *
     * @deprecated Deprecated since version 2.7, to be removed in 3.0. Use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter instead.
     *
     * @param array $camelizedAttributes
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setCamelizedAttributes(array $camelizedAttributes)
    {
        @trigger_error(sprintf('%s is deprecated since version 2.7 and will be removed in 3.0. Use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter instead.', __METHOD__), E_USER_DEPRECATED);

        if ($this->nameConverter && !$this->nameConverter instanceof CamelCaseToSnakeCaseNameConverter) {
            throw new LogicException(sprintf('%s cannot be called if a custom Name Converter is defined.', __METHOD__));
        }

        $attributes = array();
        foreach ($camelizedAttributes as $camelizedAttribute) {
            $attributes[] = lcfirst(preg_replace_callback('/(^|_|\.)+(.)/', function ($match) {
                return ('.' === $match[1] ? '_' : '').strtoupper($match[2]);
            }, $camelizedAttribute));
        }

        $this->nameConverter = new CamelCaseToSnakeCaseNameConverter($attributes);

        return $this;
    }

    /**
>>>>>>> web and vendor directory from composer install
     * Detects if the configured circular reference limit is reached.
     *
     * @param object $object
     * @param array  $context
     *
     * @return bool
     *
     * @throws CircularReferenceException
     */
    protected function isCircularReference($object, &$context)
    {
        $objectHash = spl_object_hash($object);

        if (isset($context[static::CIRCULAR_REFERENCE_LIMIT][$objectHash])) {
            if ($context[static::CIRCULAR_REFERENCE_LIMIT][$objectHash] >= $this->circularReferenceLimit) {
                unset($context[static::CIRCULAR_REFERENCE_LIMIT][$objectHash]);

                return true;
            }

            ++$context[static::CIRCULAR_REFERENCE_LIMIT][$objectHash];
        } else {
            $context[static::CIRCULAR_REFERENCE_LIMIT][$objectHash] = 1;
        }

        return false;
    }

    /**
     * Handles a circular reference.
     *
     * If a circular reference handler is set, it will be called. Otherwise, a
     * {@class CircularReferenceException} will be thrown.
     *
     * @param object $object
     *
     * @return mixed
     *
     * @throws CircularReferenceException
     */
    protected function handleCircularReference($object)
    {
        if ($this->circularReferenceHandler) {
<<<<<<< HEAD
            return \call_user_func($this->circularReferenceHandler, $object);
        }

        throw new CircularReferenceException(sprintf('A circular reference has been detected when serializing the object of class "%s" (configured limit: %d)', \get_class($object), $this->circularReferenceLimit));
=======
            return call_user_func($this->circularReferenceHandler, $object);
        }

        throw new CircularReferenceException(sprintf('A circular reference has been detected (configured limit: %d).', $this->circularReferenceLimit));
    }

    /**
     * Format an attribute name, for example to convert a snake_case name to camelCase.
     *
     * @deprecated Deprecated since version 2.7, to be removed in 3.0. Use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter instead.
     *
     * @param string $attributeName
     *
     * @return string
     */
    protected function formatAttribute($attributeName)
    {
        @trigger_error(sprintf('%s is deprecated since version 2.7 and will be removed in 3.0. Use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->nameConverter ? $this->nameConverter->normalize($attributeName) : $attributeName;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Gets attributes to normalize using groups.
     *
     * @param string|object $classOrObject
     * @param array         $context
     * @param bool          $attributesAsString If false, return an array of {@link AttributeMetadataInterface}
     *
     * @return string[]|AttributeMetadataInterface[]|bool
     */
    protected function getAllowedAttributes($classOrObject, array $context, $attributesAsString = false)
    {
<<<<<<< HEAD
        if (!$this->classMetadataFactory) {
            return false;
        }

        $groups = false;
        if (isset($context[static::GROUPS]) && \is_array($context[static::GROUPS])) {
            $groups = $context[static::GROUPS];
        } elseif (!isset($context[static::ALLOW_EXTRA_ATTRIBUTES]) || $context[static::ALLOW_EXTRA_ATTRIBUTES]) {
=======
        if (!$this->classMetadataFactory || !isset($context[static::GROUPS]) || !is_array($context[static::GROUPS])) {
>>>>>>> web and vendor directory from composer install
            return false;
        }

        $allowedAttributes = array();
        foreach ($this->classMetadataFactory->getMetadataFor($classOrObject)->getAttributesMetadata() as $attributeMetadata) {
<<<<<<< HEAD
            $name = $attributeMetadata->getName();

            if (
                (false === $groups || array_intersect($attributeMetadata->getGroups(), $groups)) &&
                $this->isAllowedAttribute($classOrObject, $name, null, $context)
            ) {
                $allowedAttributes[] = $attributesAsString ? $name : $attributeMetadata;
=======
            if (count(array_intersect($attributeMetadata->getGroups(), $context[static::GROUPS]))) {
                $allowedAttributes[] = $attributesAsString ? $attributeMetadata->getName() : $attributeMetadata;
>>>>>>> web and vendor directory from composer install
            }
        }

        return $allowedAttributes;
    }

    /**
<<<<<<< HEAD
     * Is this attribute allowed?
     *
     * @param object|string $classOrObject
     * @param string        $attribute
     * @param string|null   $format
     * @param array         $context
     *
     * @return bool
     */
    protected function isAllowedAttribute($classOrObject, $attribute, $format = null, array $context = array())
    {
        if (in_array($attribute, $this->ignoredAttributes)) {
            return false;
        }

        if (isset($context[self::ATTRIBUTES][$attribute])) {
            // Nested attributes
            return true;
        }

        if (isset($context[self::ATTRIBUTES]) && is_array($context[self::ATTRIBUTES])) {
            return in_array($attribute, $context[self::ATTRIBUTES], true);
        }

        return true;
    }

    /**
=======
>>>>>>> web and vendor directory from composer install
     * Normalizes the given data to an array. It's particularly useful during
     * the denormalization process.
     *
     * @param object|array $data
     *
     * @return array
     */
    protected function prepareForDenormalization($data)
    {
        return (array) $data;
    }

    /**
<<<<<<< HEAD
     * Returns the method to use to construct an object. This method must be either
     * the object constructor or static.
     *
     * @param array            $data
     * @param string           $class
     * @param array            $context
     * @param \ReflectionClass $reflectionClass
     * @param array|bool       $allowedAttributes
     *
     * @return \ReflectionMethod|null
     */
    protected function getConstructor(array &$data, $class, array &$context, \ReflectionClass $reflectionClass, $allowedAttributes)
    {
        return $reflectionClass->getConstructor();
    }

    /**
=======
>>>>>>> web and vendor directory from composer install
     * Instantiates an object using constructor parameters when needed.
     *
     * This method also allows to denormalize data into an existing object if
     * it is present in the context with the object_to_populate. This object
     * is removed from the context before being returned to avoid side effects
     * when recursively normalizing an object graph.
     *
     * @param array            $data
     * @param string           $class
     * @param array            $context
     * @param \ReflectionClass $reflectionClass
     * @param array|bool       $allowedAttributes
<<<<<<< HEAD
     * @param string|null      $format
=======
>>>>>>> web and vendor directory from composer install
     *
     * @return object
     *
     * @throws RuntimeException
     */
<<<<<<< HEAD
    protected function instantiateObject(array &$data, $class, array &$context, \ReflectionClass $reflectionClass, $allowedAttributes/*, string $format = null*/)
    {
        if (\func_num_args() >= 6) {
            $format = \func_get_arg(5);
        } else {
            if (__CLASS__ !== \get_class($this)) {
                $r = new \ReflectionMethod($this, __FUNCTION__);
                if (__CLASS__ !== $r->getDeclaringClass()->getName()) {
                    @trigger_error(sprintf('Method %s::%s() will have a 6th `string $format = null` argument in version 4.0. Not defining it is deprecated since Symfony 3.2.', get_class($this), __FUNCTION__), E_USER_DEPRECATED);
                }
            }

            $format = null;
        }

        if (null !== $object = $this->extractObjectToPopulate($class, $context, static::OBJECT_TO_POPULATE)) {
=======
    protected function instantiateObject(array &$data, $class, array &$context, \ReflectionClass $reflectionClass, $allowedAttributes)
    {
        if (
            isset($context[static::OBJECT_TO_POPULATE]) &&
            is_object($context[static::OBJECT_TO_POPULATE]) &&
            $context[static::OBJECT_TO_POPULATE] instanceof $class
        ) {
            $object = $context[static::OBJECT_TO_POPULATE];
>>>>>>> web and vendor directory from composer install
            unset($context[static::OBJECT_TO_POPULATE]);

            return $object;
        }

<<<<<<< HEAD
        $constructor = $this->getConstructor($data, $class, $context, $reflectionClass, $allowedAttributes);
=======
        $constructor = $reflectionClass->getConstructor();
>>>>>>> web and vendor directory from composer install
        if ($constructor) {
            $constructorParameters = $constructor->getParameters();

            $params = array();
            foreach ($constructorParameters as $constructorParameter) {
                $paramName = $constructorParameter->name;
                $key = $this->nameConverter ? $this->nameConverter->normalize($paramName) : $paramName;

<<<<<<< HEAD
                $allowed = false === $allowedAttributes || \in_array($paramName, $allowedAttributes);
                $ignored = !$this->isAllowedAttribute($class, $paramName, $format, $context);
                if (method_exists($constructorParameter, 'isVariadic') && $constructorParameter->isVariadic()) {
                    if ($allowed && !$ignored && (isset($data[$key]) || array_key_exists($key, $data))) {
                        if (!\is_array($data[$paramName])) {
=======
                $allowed = $allowedAttributes === false || in_array($paramName, $allowedAttributes);
                $ignored = in_array($paramName, $this->ignoredAttributes);
                if (method_exists($constructorParameter, 'isVariadic') && $constructorParameter->isVariadic()) {
                    if ($allowed && !$ignored && (isset($data[$key]) || array_key_exists($key, $data))) {
                        if (!is_array($data[$paramName])) {
>>>>>>> web and vendor directory from composer install
                            throw new RuntimeException(sprintf('Cannot create an instance of %s from serialized data because the variadic parameter %s can only accept an array.', $class, $constructorParameter->name));
                        }

                        $params = array_merge($params, $data[$paramName]);
                    }
                } elseif ($allowed && !$ignored && (isset($data[$key]) || array_key_exists($key, $data))) {
<<<<<<< HEAD
                    $parameterData = $data[$key];
                    try {
                        if (null !== $constructorParameter->getClass()) {
                            if (!$this->serializer instanceof DenormalizerInterface) {
                                throw new LogicException(sprintf('Cannot create an instance of %s from serialized data because the serializer inject in "%s" is not a denormalizer', $constructorParameter->getClass(), static::class));
                            }
                            $parameterClass = $constructorParameter->getClass()->getName();
                            $parameterData = $this->serializer->denormalize($parameterData, $parameterClass, $format, $this->createChildContext($context, $paramName));
                        }
                    } catch (\ReflectionException $e) {
                        throw new RuntimeException(sprintf('Could not determine the class of the parameter "%s".', $key), 0, $e);
                    }

                    // Don't run set for a parameter passed to the constructor
                    $params[] = $parameterData;
=======
                    $params[] = $data[$key];
                    // don't run set for a parameter passed to the constructor
>>>>>>> web and vendor directory from composer install
                    unset($data[$key]);
                } elseif ($constructorParameter->isDefaultValueAvailable()) {
                    $params[] = $constructorParameter->getDefaultValue();
                } else {
                    throw new RuntimeException(
                        sprintf(
                            'Cannot create an instance of %s from serialized data because its constructor requires parameter "%s" to be present.',
                            $class,
                            $constructorParameter->name
                        )
                    );
                }
            }

<<<<<<< HEAD
            if ($constructor->isConstructor()) {
                return $reflectionClass->newInstanceArgs($params);
            } else {
                return $constructor->invokeArgs(null, $params);
            }
=======
            return $reflectionClass->newInstanceArgs($params);
>>>>>>> web and vendor directory from composer install
        }

        return new $class();
    }
<<<<<<< HEAD

    /**
     * @param array  $parentContext
     * @param string $attribute
     *
     * @return array
     *
     * @internal
     */
    protected function createChildContext(array $parentContext, $attribute)
    {
        if (isset($parentContext[self::ATTRIBUTES][$attribute])) {
            $parentContext[self::ATTRIBUTES] = $parentContext[self::ATTRIBUTES][$attribute];
        } else {
            unset($parentContext[self::ATTRIBUTES]);
        }

        return $parentContext;
    }
=======
>>>>>>> web and vendor directory from composer install
}
