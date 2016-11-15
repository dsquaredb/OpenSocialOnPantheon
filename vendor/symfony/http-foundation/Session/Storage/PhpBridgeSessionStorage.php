<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Storage;

<<<<<<< HEAD
=======
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\AbstractProxy;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeSessionHandler;

>>>>>>> web and vendor directory from composer install
/**
 * Allows session to be started by PHP and managed by Symfony.
 *
 * @author Drak <drak@zikula.org>
 */
class PhpBridgeSessionStorage extends NativeSessionStorage
{
    /**
<<<<<<< HEAD
     * @param \SessionHandlerInterface|null $handler
     * @param MetadataBag                   $metaBag MetadataBag
=======
     * Constructor.
     *
     * @param AbstractProxy|NativeSessionHandler|\SessionHandlerInterface|null $handler
     * @param MetadataBag                                                      $metaBag MetadataBag
>>>>>>> web and vendor directory from composer install
     */
    public function __construct($handler = null, MetadataBag $metaBag = null)
    {
        $this->setMetadataBag($metaBag);
        $this->setSaveHandler($handler);
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        if ($this->started) {
            return true;
        }

        $this->loadSession();
<<<<<<< HEAD
=======
        if (!$this->saveHandler->isWrapper() && !$this->saveHandler->isSessionHandlerInterface()) {
            // This condition matches only PHP 5.3 + internal save handlers
            $this->saveHandler->setActive(true);
        }
>>>>>>> web and vendor directory from composer install

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        // clear out the bags and nothing else that may be set
        // since the purpose of this driver is to share a handler
        foreach ($this->bags as $bag) {
            $bag->clear();
        }

        // reconnect the bags to the session
        $this->loadSession();
    }
}
