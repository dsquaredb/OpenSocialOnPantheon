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
 * MemcachedSessionHandler.
 *
>>>>>>> web and vendor directory from composer install
 * Memcached based session storage handler based on the Memcached class
 * provided by the PHP memcached extension.
 *
 * @see http://php.net/memcached
 *
 * @author Drak <drak@zikula.org>
 */
<<<<<<< HEAD
class MemcachedSessionHandler extends AbstractSessionHandler
{
=======
class MemcachedSessionHandler implements \SessionHandlerInterface
{
    /**
     * @var \Memcached Memcached driver
     */
>>>>>>> web and vendor directory from composer install
    private $memcached;

    /**
     * @var int Time to live in seconds
     */
    private $ttl;

    /**
     * @var string Key prefix for shared environments
     */
    private $prefix;

    /**
     * Constructor.
     *
     * List of available options:
     *  * prefix: The prefix to use for the memcached keys in order to avoid collision
<<<<<<< HEAD
     *  * expiretime: The time to live in seconds.
=======
     *  * expiretime: The time to live in seconds
>>>>>>> web and vendor directory from composer install
     *
     * @param \Memcached $memcached A \Memcached instance
     * @param array      $options   An associative array of Memcached options
     *
     * @throws \InvalidArgumentException When unsupported options are passed
     */
    public function __construct(\Memcached $memcached, array $options = array())
    {
        $this->memcached = $memcached;

        if ($diff = array_diff(array_keys($options), array('prefix', 'expiretime'))) {
            throw new \InvalidArgumentException(sprintf(
                'The following options are not supported "%s"', implode(', ', $diff)
            ));
        }

        $this->ttl = isset($options['expiretime']) ? (int) $options['expiretime'] : 86400;
        $this->prefix = isset($options['prefix']) ? $options['prefix'] : 'sf2s';
    }

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
    protected function doRead($sessionId)
    {
        return $this->memcached->get($this->prefix.$sessionId) ?: '';
=======
    public function close()
    {
        return true;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function updateTimestamp($sessionId, $data)
    {
        $this->memcached->touch($this->prefix.$sessionId, time() + $this->ttl);

        return true;
=======
    public function read($sessionId)
    {
        return $this->memcached->get($this->prefix.$sessionId) ?: '';
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function doWrite($sessionId, $data)
=======
    public function write($sessionId, $data)
>>>>>>> web and vendor directory from composer install
    {
        return $this->memcached->set($this->prefix.$sessionId, $data, time() + $this->ttl);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function doDestroy($sessionId)
    {
        $result = $this->memcached->delete($this->prefix.$sessionId);

        return $result || \Memcached::RES_NOTFOUND == $this->memcached->getResultCode();
=======
    public function destroy($sessionId)
    {
        return $this->memcached->delete($this->prefix.$sessionId);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function gc($maxlifetime)
    {
        // not required here because memcached will auto expire the records anyhow.
        return true;
    }

    /**
     * Return a Memcached instance.
     *
     * @return \Memcached
     */
    protected function getMemcached()
    {
        return $this->memcached;
    }
}
