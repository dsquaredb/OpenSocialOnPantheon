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
 
=======
 * NullSessionHandler.
 *
 * Can be used in unit testing or in a situations where persisted sessions are not desired.
 *
 * @author Drak <drak@zikula.org>
 */
 
class NullSessionHandler extends AbstractSessionHandler
=======
class NullSessionHandler implements \SessionHandlerInterface
{
    /**
     * {@inheritdoc}
     */
 
    public function close()
=======
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
 
    public function validateId($sessionId)
=======
    public function close()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
 
    protected function doRead($sessionId)
=======
    public function read($sessionId)
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
 
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
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
 
    protected function doDestroy($sessionId)
=======
    public function destroy($sessionId)
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
