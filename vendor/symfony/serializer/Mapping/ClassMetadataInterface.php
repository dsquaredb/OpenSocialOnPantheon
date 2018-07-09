<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer\Mapping;

/**
 * Stores metadata needed for serializing and deserializing objects of specific class.
 *
 * Primarily, the metadata stores the set of attributes to serialize or deserialize.
 *
 * There may only exist one metadata for each attribute according to its name.
 *
 * @internal
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface ClassMetadataInterface
{
    /**
     * Returns the name of the backing PHP class.
     *
     * @return string The name of the backing class
     */
    public function getName();

    /**
     * Adds an {@link AttributeMetadataInterface}.
<<<<<<< HEAD
=======
     *
     * @param AttributeMetadataInterface $attributeMetadata
>>>>>>> web and vendor directory from composer install
     */
    public function addAttributeMetadata(AttributeMetadataInterface $attributeMetadata);

    /**
     * Gets the list of {@link AttributeMetadataInterface}.
     *
     * @return AttributeMetadataInterface[]
     */
    public function getAttributesMetadata();

    /**
     * Merges a {@link ClassMetadataInterface} in the current one.
<<<<<<< HEAD
     */
    public function merge(self $classMetadata);
=======
     *
     * @param ClassMetadataInterface $classMetadata
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function merge(ClassMetadataInterface $classMetadata);
>>>>>>> web and vendor directory from composer install
=======
    public function merge(self $classMetadata);
>>>>>>> Update Open Social to 8.x-2.1
=======
    public function merge(ClassMetadataInterface $classMetadata);
>>>>>>> revert Open Social update
=======
    public function merge(self $classMetadata);
>>>>>>> updating open social

    /**
     * Returns a {@link \ReflectionClass} instance for this class.
     *
     * @return \ReflectionClass
     */
    public function getReflectionClass();
}
