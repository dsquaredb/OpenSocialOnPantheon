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
 * {@inheritdoc}
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class AttributeMetadata implements AttributeMetadataInterface
{
    /**
<<<<<<< HEAD
=======
     * @var string
     *
>>>>>>> web and vendor directory from composer install
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getName()} instead.
     */
    public $name;

    /**
<<<<<<< HEAD
=======
     * @var array
     *
>>>>>>> web and vendor directory from composer install
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getGroups()} instead.
     */
    public $groups = array();

    /**
<<<<<<< HEAD
     * @var int|null
     *
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getMaxDepth()} instead.
     */
    public $maxDepth;

    /**
=======
>>>>>>> web and vendor directory from composer install
     * Constructs a metadata for the given attribute.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function addGroup($group)
    {
<<<<<<< HEAD
        if (!\in_array($group, $this->groups)) {
=======
        if (!in_array($group, $this->groups)) {
>>>>>>> web and vendor directory from composer install
            $this->groups[] = $group;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setMaxDepth($maxDepth)
    {
        $this->maxDepth = $maxDepth;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxDepth()
    {
        return $this->maxDepth;
    }

    /**
     * {@inheritdoc}
     */
=======
>>>>>>> web and vendor directory from composer install
    public function merge(AttributeMetadataInterface $attributeMetadata)
    {
        foreach ($attributeMetadata->getGroups() as $group) {
            $this->addGroup($group);
        }
<<<<<<< HEAD

        // Overwrite only if not defined
        if (null === $this->maxDepth) {
            $this->maxDepth = $attributeMetadata->getMaxDepth();
        }
=======
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Returns the names of the properties that should be serialized.
     *
     * @return string[]
     */
    public function __sleep()
    {
<<<<<<< HEAD
        return array('name', 'groups', 'maxDepth');
=======
        return array('name', 'groups');
>>>>>>> web and vendor directory from composer install
    }
}
