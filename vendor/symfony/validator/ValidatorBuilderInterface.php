<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator;

use Doctrine\Common\Annotations\Reader;
<<<<<<< HEAD
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Mapping\Cache\CacheInterface;
use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
=======
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Mapping\Cache\CacheInterface;
>>>>>>> web and vendor directory from composer install

/**
 * A configurable builder for ValidatorInterface objects.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
interface ValidatorBuilderInterface
{
    /**
     * Adds an object initializer to the validator.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @param ObjectInitializerInterface $initializer The initializer
     *
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function addObjectInitializer(ObjectInitializerInterface $initializer);

    /**
     * Adds a list of object initializers to the validator.
     *
<<<<<<< HEAD
     * @param ObjectInitializerInterface[] $initializers
     *
     * @return $this
=======
     * @param array $initializers The initializer
     *
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function addObjectInitializers(array $initializers);

    /**
     * Adds an XML constraint mapping file to the validator.
     *
     * @param string $path The path to the mapping file
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function addXmlMapping($path);

    /**
     * Adds a list of XML constraint mapping files to the validator.
     *
<<<<<<< HEAD
     * @param string[] $paths The paths to the mapping files
     *
     * @return $this
=======
     * @param array $paths The paths to the mapping files
     *
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function addXmlMappings(array $paths);

    /**
     * Adds a YAML constraint mapping file to the validator.
     *
     * @param string $path The path to the mapping file
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function addYamlMapping($path);

    /**
     * Adds a list of YAML constraint mappings file to the validator.
     *
<<<<<<< HEAD
     * @param string[] $paths The paths to the mapping files
     *
     * @return $this
=======
     * @param array $paths The paths to the mapping files
     *
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function addYamlMappings(array $paths);

    /**
     * Enables constraint mapping using the given static method.
     *
     * @param string $methodName The name of the method
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function addMethodMapping($methodName);

    /**
     * Enables constraint mapping using the given static methods.
     *
<<<<<<< HEAD
     * @param string[] $methodNames The names of the methods
     *
     * @return $this
=======
     * @param array $methodNames The names of the methods
     *
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function addMethodMappings(array $methodNames);

    /**
     * Enables annotation based constraint mapping.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @param Reader $annotationReader The annotation reader to be used
     *
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function enableAnnotationMapping(Reader $annotationReader = null);

    /**
     * Disables annotation based constraint mapping.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function disableAnnotationMapping();

    /**
     * Sets the class metadata factory used by the validator.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @param MetadataFactoryInterface $metadataFactory The metadata factory
     *
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function setMetadataFactory(MetadataFactoryInterface $metadataFactory);

    /**
     * Sets the cache for caching class metadata.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @param CacheInterface $cache The cache instance
     *
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function setMetadataCache(CacheInterface $cache);

    /**
     * Sets the constraint validator factory used by the validator.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @param ConstraintValidatorFactoryInterface $validatorFactory The validator factory
     *
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function setConstraintValidatorFactory(ConstraintValidatorFactoryInterface $validatorFactory);

    /**
     * Sets the translator used for translating violation messages.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @param TranslatorInterface $translator The translator instance
     *
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function setTranslator(TranslatorInterface $translator);

    /**
     * Sets the default translation domain of violation messages.
     *
     * The same message can have different translations in different domains.
     * Pass the domain that is used for violation messages by default to this
     * method.
     *
     * @param string $translationDomain The translation domain of the violation messages
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ValidatorBuilderInterface The builder object
>>>>>>> web and vendor directory from composer install
     */
    public function setTranslationDomain($translationDomain);

    /**
<<<<<<< HEAD
=======
     * Sets the property accessor for resolving property paths.
     *
     * @param PropertyAccessorInterface $propertyAccessor The property accessor
     *
     * @return ValidatorBuilderInterface The builder object
     *
     * @deprecated since version 2.5, to be removed in 3.0.
     */
    public function setPropertyAccessor(PropertyAccessorInterface $propertyAccessor);

    /**
     * Sets the API version that the returned validator should support.
     *
     * @param int $apiVersion The required API version
     *
     * @return ValidatorBuilderInterface The builder object
     *
     * @see Validation::API_VERSION_2_5
     * @see Validation::API_VERSION_2_5_BC
     * @deprecated since version 2.7, to be removed in 3.0.
     */
    public function setApiVersion($apiVersion);

    /**
>>>>>>> web and vendor directory from composer install
     * Builds and returns a new validator object.
     *
     * @return ValidatorInterface The built validator
     */
    public function getValidator();
}
