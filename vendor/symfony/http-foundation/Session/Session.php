<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session;

use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

/**
<<<<<<< HEAD
=======
 * Session.
 *
>>>>>>> web and vendor directory from composer install
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Drak <drak@zikula.org>
 */
class Session implements SessionInterface, \IteratorAggregate, \Countable
{
<<<<<<< HEAD
    protected $storage;

    private $flashName;
    private $attributeName;
    private $data = array();
    private $usageIndex = 0;

    /**
=======
    /**
     * Storage driver.
     *
     * @var SessionStorageInterface
     */
    protected $storage;

    /**
     * @var string
     */
    private $flashName;

    /**
     * @var string
     */
    private $attributeName;

    /**
     * Constructor.
     *
>>>>>>> web and vendor directory from composer install
     * @param SessionStorageInterface $storage    A SessionStorageInterface instance
     * @param AttributeBagInterface   $attributes An AttributeBagInterface instance, (defaults null for default AttributeBag)
     * @param FlashBagInterface       $flashes    A FlashBagInterface instance (defaults null for default FlashBag)
     */
    public function __construct(SessionStorageInterface $storage = null, AttributeBagInterface $attributes = null, FlashBagInterface $flashes = null)
    {
        $this->storage = $storage ?: new NativeSessionStorage();

        $attributes = $attributes ?: new AttributeBag();
        $this->attributeName = $attributes->getName();
        $this->registerBag($attributes);

        $flashes = $flashes ?: new FlashBag();
        $this->flashName = $flashes->getName();
        $this->registerBag($flashes);
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        ++$this->usageIndex;

        return $this->storage->start();
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
<<<<<<< HEAD
        return $this->getAttributeBag()->has($name);
=======
        return $this->storage->getBag($this->attributeName)->has($name);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function get($name, $default = null)
    {
<<<<<<< HEAD
        return $this->getAttributeBag()->get($name, $default);
=======
        return $this->storage->getBag($this->attributeName)->get($name, $default);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
<<<<<<< HEAD
        $this->getAttributeBag()->set($name, $value);
=======
        $this->storage->getBag($this->attributeName)->set($name, $value);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
<<<<<<< HEAD
        return $this->getAttributeBag()->all();
=======
        return $this->storage->getBag($this->attributeName)->all();
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function replace(array $attributes)
    {
<<<<<<< HEAD
        $this->getAttributeBag()->replace($attributes);
=======
        $this->storage->getBag($this->attributeName)->replace($attributes);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
<<<<<<< HEAD
        return $this->getAttributeBag()->remove($name);
=======
        return $this->storage->getBag($this->attributeName)->remove($name);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
<<<<<<< HEAD
        $this->getAttributeBag()->clear();
=======
        $this->storage->getBag($this->attributeName)->clear();
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted()
    {
        return $this->storage->isStarted();
    }

    /**
     * Returns an iterator for attributes.
     *
     * @return \ArrayIterator An \ArrayIterator instance
     */
    public function getIterator()
    {
<<<<<<< HEAD
        return new \ArrayIterator($this->getAttributeBag()->all());
=======
        return new \ArrayIterator($this->storage->getBag($this->attributeName)->all());
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Returns the number of attributes.
     *
     * @return int The number of attributes
     */
    public function count()
    {
<<<<<<< HEAD
        return count($this->getAttributeBag()->all());
    }

    /**
     * @return int
     *
     * @internal
     */
    public function getUsageIndex()
    {
        return $this->usageIndex;
    }

    /**
     * @return bool
     *
     * @internal
     */
    public function isEmpty()
    {
        ++$this->usageIndex;
        foreach ($this->data as &$data) {
            if (!empty($data)) {
                return false;
            }
        }

        return true;
=======
        return count($this->storage->getBag($this->attributeName)->all());
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function invalidate($lifetime = null)
    {
        $this->storage->clear();

        return $this->migrate(true, $lifetime);
    }

    /**
     * {@inheritdoc}
     */
    public function migrate($destroy = false, $lifetime = null)
    {
        ++$this->usageIndex;

        return $this->storage->regenerate($destroy, $lifetime);
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        ++$this->usageIndex;

        $this->storage->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->storage->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->storage->setId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->storage->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->storage->setName($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadataBag()
    {
        ++$this->usageIndex;

        return $this->storage->getMetadataBag();
    }

    /**
     * {@inheritdoc}
     */
    public function registerBag(SessionBagInterface $bag)
    {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        $this->storage->registerBag(new SessionBagProxy($bag, $this->data, $this->hasBeenStarted));
=======
        $this->storage->registerBag($bag);
>>>>>>> web and vendor directory from composer install
=======
        $this->storage->registerBag(new SessionBagProxy($bag, $this->data, $this->usageIndex));
>>>>>>> Update Open Social to 8.x-2.1
=======
        $this->storage->registerBag(new SessionBagProxy($bag, $this->data, $this->hasBeenStarted));
>>>>>>> revert Open Social update
=======
        $this->storage->registerBag(new SessionBagProxy($bag, $this->data, $this->usageIndex));
>>>>>>> updating open social
    }

    /**
     * {@inheritdoc}
     */
    public function getBag($name)
    {
<<<<<<< HEAD
        return $this->storage->getBag($name)->getBag();
=======
        return $this->storage->getBag($name);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Gets the flashbag interface.
     *
     * @return FlashBagInterface
     */
    public function getFlashBag()
    {
        return $this->getBag($this->flashName);
    }
<<<<<<< HEAD

    /**
     * Gets the attributebag interface.
     *
     * Note that this method was added to help with IDE autocompletion.
     *
     * @return AttributeBagInterface
     */
    private function getAttributeBag()
    {
        return $this->getBag($this->attributeName);
    }
=======
>>>>>>> web and vendor directory from composer install
}
