<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer\Mapping\Loader;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Serializer\Annotation\Groups;
<<<<<<< HEAD
use Symfony\Component\Serializer\Annotation\MaxDepth;
=======
>>>>>>> web and vendor directory from composer install
use Symfony\Component\Serializer\Exception\MappingException;
use Symfony\Component\Serializer\Mapping\AttributeMetadata;
use Symfony\Component\Serializer\Mapping\ClassMetadataInterface;

/**
 * Annotation loader.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class AnnotationLoader implements LoaderInterface
{
<<<<<<< HEAD
    private $reader;

=======
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param Reader $reader
     */
>>>>>>> web and vendor directory from composer install
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * {@inheritdoc}
     */
    public function loadClassMetadata(ClassMetadataInterface $classMetadata)
    {
        $reflectionClass = $classMetadata->getReflectionClass();
        $className = $reflectionClass->name;
        $loaded = false;

        $attributesMetadata = $classMetadata->getAttributesMetadata();

        foreach ($reflectionClass->getProperties() as $property) {
            if (!isset($attributesMetadata[$property->name])) {
                $attributesMetadata[$property->name] = new AttributeMetadata($property->name);
                $classMetadata->addAttributeMetadata($attributesMetadata[$property->name]);
            }

            if ($property->getDeclaringClass()->name === $className) {
<<<<<<< HEAD
                foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                    if ($annotation instanceof Groups) {
                        foreach ($annotation->getGroups() as $group) {
                            $attributesMetadata[$property->name]->addGroup($group);
                        }
                    } elseif ($annotation instanceof MaxDepth) {
                        $attributesMetadata[$property->name]->setMaxDepth($annotation->getMaxDepth());
=======
                foreach ($this->reader->getPropertyAnnotations($property) as $groups) {
                    if ($groups instanceof Groups) {
                        foreach ($groups->getGroups() as $group) {
                            $attributesMetadata[$property->name]->addGroup($group);
                        }
>>>>>>> web and vendor directory from composer install
                    }

                    $loaded = true;
                }
            }
        }

        foreach ($reflectionClass->getMethods() as $method) {
<<<<<<< HEAD
            if ($method->getDeclaringClass()->name !== $className) {
                continue;
            }

            $accessorOrMutator = preg_match('/^(get|is|has|set)(.+)$/i', $method->name, $matches);
            if ($accessorOrMutator) {
                $attributeName = lcfirst($matches[2]);

                if (isset($attributesMetadata[$attributeName])) {
                    $attributeMetadata = $attributesMetadata[$attributeName];
                } else {
                    $attributesMetadata[$attributeName] = $attributeMetadata = new AttributeMetadata($attributeName);
                    $classMetadata->addAttributeMetadata($attributeMetadata);
                }
            }

            foreach ($this->reader->getMethodAnnotations($method) as $annotation) {
                if ($annotation instanceof Groups) {
                    if (!$accessorOrMutator) {
                        throw new MappingException(sprintf('Groups on "%s::%s" cannot be added. Groups can only be added on methods beginning with "get", "is", "has" or "set".', $className, $method->name));
                    }

                    foreach ($annotation->getGroups() as $group) {
                        $attributeMetadata->addGroup($group);
                    }
                } elseif ($annotation instanceof MaxDepth) {
                    if (!$accessorOrMutator) {
                        throw new MappingException(sprintf('MaxDepth on "%s::%s" cannot be added. MaxDepth can only be added on methods beginning with "get", "is", "has" or "set".', $className, $method->name));
                    }

                    $attributeMetadata->setMaxDepth($annotation->getMaxDepth());
                }

                $loaded = true;
=======
            if ($method->getDeclaringClass()->name === $className) {
                foreach ($this->reader->getMethodAnnotations($method) as $groups) {
                    if ($groups instanceof Groups) {
                        if (preg_match('/^(get|is|has|set)(.+)$/i', $method->name, $matches)) {
                            $attributeName = lcfirst($matches[2]);

                            if (isset($attributesMetadata[$attributeName])) {
                                $attributeMetadata = $attributesMetadata[$attributeName];
                            } else {
                                $attributesMetadata[$attributeName] = $attributeMetadata = new AttributeMetadata($attributeName);
                                $classMetadata->addAttributeMetadata($attributeMetadata);
                            }

                            foreach ($groups->getGroups() as $group) {
                                $attributeMetadata->addGroup($group);
                            }
                        } else {
                            throw new MappingException(sprintf('Groups on "%s::%s" cannot be added. Groups can only be added on methods beginning with "get", "is", "has" or "set".', $className, $method->name));
                        }
                    }

                    $loaded = true;
                }
>>>>>>> web and vendor directory from composer install
            }
        }

        return $loaded;
    }
}
