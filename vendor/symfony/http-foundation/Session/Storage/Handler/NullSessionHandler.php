<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Storage\Handler;

/**
<<<<<<< HEAD
=======
 * NullSessionHandler.
 *
>>>>>>> web and vendor directory from composer install
 * Can be used in unit testing or in a situations where persisted sessions are not desired.
 *
 * @author Drak <drak@zikula.org>
 */
<<<<<<< HEAD
class NullSessionHandler extends AbstractSessionHandler
=======
class NullSessionHandler implements \SessionHandlerInterface
>>>>>>> web and vendor directory from composer install
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function close()
=======
    public function open($savePath, $sessionName)
>>>>>>> web and vendor directory from composer install
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function validateId($sessionId)
=======
    public function close()
>>>>>>> web and vendor directory from composer install
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function doRead($sessionId)
=======
    public function read($sessionId)
>>>>>>> web and vendor directory from composer install
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function updateTimestamp($sessionId, $data)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function doWrite($sessionId, $data)
=======
    public function write($sessionId, $data)
>>>>>>> web and vendor directory from composer install
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function doDestroy($sessionId)
=======
    public function destroy($sessionId)
>>>>>>> web and vendor directory from composer install
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function gc($maxlifetime)
    {
        return true;
    }
}
