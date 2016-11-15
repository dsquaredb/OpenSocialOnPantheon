<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Profiler;

use Symfony\Component\HttpFoundation\Exception\ConflictingHeadersException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;
use Symfony\Component\HttpKernel\DataCollector\LateDataCollectorInterface;
use Psr\Log\LoggerInterface;

/**
 * Profiler.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Profiler
{
<<<<<<< HEAD
=======
    /**
     * @var ProfilerStorageInterface
     */
>>>>>>> web and vendor directory from composer install
    private $storage;

    /**
     * @var DataCollectorInterface[]
     */
    private $collectors = array();

<<<<<<< HEAD
    private $logger;
    private $initiallyEnabled = true;
    private $enabled = true;

    /**
     * @param bool $enable The initial enabled state
     */
    public function __construct(ProfilerStorageInterface $storage, LoggerInterface $logger = null, $enable = true)
    {
        $this->storage = $storage;
        $this->logger = $logger;
        $this->initiallyEnabled = $this->enabled = (bool) $enable;
=======
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var bool
     */
    private $enabled = true;

    /**
     * Constructor.
     *
     * @param ProfilerStorageInterface $storage A ProfilerStorageInterface instance
     * @param LoggerInterface          $logger  A LoggerInterface instance
     */
    public function __construct(ProfilerStorageInterface $storage, LoggerInterface $logger = null)
    {
        $this->storage = $storage;
        $this->logger = $logger;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Disables the profiler.
     */
    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * Enables the profiler.
     */
    public function enable()
    {
        $this->enabled = true;
    }

    /**
     * Loads the Profile for the given Response.
     *
<<<<<<< HEAD
=======
     * @param Response $response A Response instance
     *
>>>>>>> web and vendor directory from composer install
     * @return Profile|false A Profile instance
     */
    public function loadProfileFromResponse(Response $response)
    {
        if (!$token = $response->headers->get('X-Debug-Token')) {
            return false;
        }

        return $this->loadProfile($token);
    }

    /**
     * Loads the Profile for the given token.
     *
     * @param string $token A token
     *
     * @return Profile A Profile instance
     */
    public function loadProfile($token)
    {
        return $this->storage->read($token);
    }

    /**
     * Saves a Profile.
     *
<<<<<<< HEAD
=======
     * @param Profile $profile A Profile instance
     *
>>>>>>> web and vendor directory from composer install
     * @return bool
     */
    public function saveProfile(Profile $profile)
    {
        // late collect
        foreach ($profile->getCollectors() as $collector) {
            if ($collector instanceof LateDataCollectorInterface) {
                $collector->lateCollect();
            }
        }

        if (!($ret = $this->storage->write($profile)) && null !== $this->logger) {
            $this->logger->warning('Unable to store the profiler information.', array('configured_storage' => get_class($this->storage)));
        }

        return $ret;
    }

    /**
     * Purges all data from the storage.
     */
    public function purge()
    {
        $this->storage->purge();
    }

    /**
<<<<<<< HEAD
     * Finds profiler tokens for the given criteria.
     *
     * @param string $ip         The IP
     * @param string $url        The URL
     * @param string $limit      The maximum number of tokens to return
     * @param string $method     The request method
     * @param string $start      The start date to search from
     * @param string $end        The end date to search to
     * @param string $statusCode The request status code
=======
     * Exports the current profiler data.
     *
     * @param Profile $profile A Profile instance
     *
     * @return string The exported data
     *
     * @deprecated since Symfony 2.8, to be removed in 3.0.
     */
    public function export(Profile $profile)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.8 and will be removed in 3.0.', E_USER_DEPRECATED);

        return base64_encode(serialize($profile));
    }

    /**
     * Imports data into the profiler storage.
     *
     * @param string $data A data string as exported by the export() method
     *
     * @return Profile|false A Profile instance
     *
     * @deprecated since Symfony 2.8, to be removed in 3.0.
     */
    public function import($data)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.8 and will be removed in 3.0.', E_USER_DEPRECATED);

        $profile = unserialize(base64_decode($data));

        if ($this->storage->read($profile->getToken())) {
            return false;
        }

        $this->saveProfile($profile);

        return $profile;
    }

    /**
     * Finds profiler tokens for the given criteria.
     *
     * @param string $ip     The IP
     * @param string $url    The URL
     * @param string $limit  The maximum number of tokens to return
     * @param string $method The request method
     * @param string $start  The start date to search from
     * @param string $end    The end date to search to
>>>>>>> web and vendor directory from composer install
     *
     * @return array An array of tokens
     *
     * @see http://php.net/manual/en/datetime.formats.php for the supported date/time formats
     */
<<<<<<< HEAD
    public function find($ip, $url, $limit, $method, $start, $end, $statusCode = null)
    {
        return $this->storage->find($ip, $url, $limit, $method, $this->getTimestamp($start), $this->getTimestamp($end), $statusCode);
=======
    public function find($ip, $url, $limit, $method, $start, $end)
    {
        return $this->storage->find($ip, $url, $limit, $method, $this->getTimestamp($start), $this->getTimestamp($end));
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Collects data for the given Response.
     *
<<<<<<< HEAD
=======
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An exception instance if the request threw one
     *
>>>>>>> web and vendor directory from composer install
     * @return Profile|null A Profile instance or null if the profiler is disabled
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if (false === $this->enabled) {
            return;
        }

        $profile = new Profile(substr(hash('sha256', uniqid(mt_rand(), true)), 0, 6));
        $profile->setTime(time());
        $profile->setUrl($request->getUri());
        $profile->setMethod($request->getMethod());
        $profile->setStatusCode($response->getStatusCode());
        try {
            $profile->setIp($request->getClientIp());
        } catch (ConflictingHeadersException $e) {
            $profile->setIp('Unknown');
        }

        $response->headers->set('X-Debug-Token', $profile->getToken());

        foreach ($this->collectors as $collector) {
            $collector->collect($request, $response, $exception);

            // we need to clone for sub-requests
            $profile->addCollector(clone $collector);
        }

        return $profile;
    }

<<<<<<< HEAD
    public function reset()
    {
        foreach ($this->collectors as $collector) {
            if (!method_exists($collector, 'reset')) {
                continue;
            }

            $collector->reset();
        }
        $this->enabled = $this->initiallyEnabled;
    }

=======
>>>>>>> web and vendor directory from composer install
    /**
     * Gets the Collectors associated with this profiler.
     *
     * @return array An array of collectors
     */
    public function all()
    {
        return $this->collectors;
    }

    /**
     * Sets the Collectors associated with this profiler.
     *
     * @param DataCollectorInterface[] $collectors An array of collectors
     */
    public function set(array $collectors = array())
    {
        $this->collectors = array();
        foreach ($collectors as $collector) {
            $this->add($collector);
        }
    }

    /**
     * Adds a Collector.
<<<<<<< HEAD
     */
    public function add(DataCollectorInterface $collector)
    {
        if (!method_exists($collector, 'reset')) {
            @trigger_error(sprintf('Implementing "%s" without the "reset()" method is deprecated since Symfony 3.4 and will be unsupported in 4.0 for class "%s".', DataCollectorInterface::class, \get_class($collector)), E_USER_DEPRECATED);
        }

=======
     *
     * @param DataCollectorInterface $collector A DataCollectorInterface instance
     */
    public function add(DataCollectorInterface $collector)
    {
>>>>>>> web and vendor directory from composer install
        $this->collectors[$collector->getName()] = $collector;
    }

    /**
     * Returns true if a Collector for the given name exists.
     *
     * @param string $name A collector name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->collectors[$name]);
    }

    /**
     * Gets a Collector by name.
     *
     * @param string $name A collector name
     *
     * @return DataCollectorInterface A DataCollectorInterface instance
     *
     * @throws \InvalidArgumentException if the collector does not exist
     */
    public function get($name)
    {
        if (!isset($this->collectors[$name])) {
            throw new \InvalidArgumentException(sprintf('Collector "%s" does not exist.', $name));
        }

        return $this->collectors[$name];
    }

    private function getTimestamp($value)
    {
        if (null === $value || '' == $value) {
            return;
        }

        try {
            $value = new \DateTime(is_numeric($value) ? '@'.$value : $value);
        } catch (\Exception $e) {
            return;
        }

        return $value->getTimestamp();
    }
}
