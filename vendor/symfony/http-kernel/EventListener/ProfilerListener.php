<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\EventListener;

<<<<<<< HEAD
=======
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
>>>>>>> web and vendor directory from composer install
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * ProfilerListener collects data for the current request by listening to the kernel events.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ProfilerListener implements EventSubscriberInterface
{
    protected $profiler;
    protected $matcher;
    protected $onlyException;
    protected $onlyMasterRequests;
    protected $exception;
<<<<<<< HEAD
=======
    protected $requests = array();
>>>>>>> web and vendor directory from composer install
    protected $profiles;
    protected $requestStack;
    protected $parents;

    /**
<<<<<<< HEAD
     * @param Profiler                     $profiler           A Profiler instance
     * @param RequestStack                 $requestStack       A RequestStack instance
     * @param RequestMatcherInterface|null $matcher            A RequestMatcher instance
     * @param bool                         $onlyException      True if the profiler only collects data when an exception occurs, false otherwise
     * @param bool                         $onlyMasterRequests True if the profiler only collects data when the request is a master request, false otherwise
     */
    public function __construct(Profiler $profiler, RequestStack $requestStack, RequestMatcherInterface $matcher = null, $onlyException = false, $onlyMasterRequests = false)
    {
=======
     * Constructor.
     *
     * @param Profiler                     $profiler           A Profiler instance
     * @param RequestStack                 $requestStack       A RequestStack instance
     * @param RequestMatcherInterface|null $matcher            A RequestMatcher instance
     * @param bool                         $onlyException      true if the profiler only collects data when an exception occurs, false otherwise
     * @param bool                         $onlyMasterRequests true if the profiler only collects data when the request is a master request, false otherwise
     */
    public function __construct(Profiler $profiler, $requestStack = null, $matcher = null, $onlyException = false, $onlyMasterRequests = false)
    {
        if ($requestStack instanceof RequestMatcherInterface || (null !== $matcher && !$matcher instanceof RequestMatcherInterface) || $onlyMasterRequests instanceof RequestStack) {
            $tmp = $onlyMasterRequests;
            $onlyMasterRequests = $onlyException;
            $onlyException = $matcher;
            $matcher = $requestStack;
            $requestStack = func_num_args() < 5 ? null : $tmp;

            @trigger_error('The '.__METHOD__.' method now requires a RequestStack to be given as second argument as '.__CLASS__.'::onKernelRequest method will be removed in 3.0.', E_USER_DEPRECATED);
        } elseif (!$requestStack instanceof RequestStack) {
            @trigger_error('The '.__METHOD__.' method now requires a RequestStack instance as '.__CLASS__.'::onKernelRequest method will be removed in 3.0.', E_USER_DEPRECATED);
        }

        if (null !== $requestStack && !$requestStack instanceof RequestStack) {
            throw new \InvalidArgumentException('RequestStack instance expected.');
        }
        if (null !== $matcher && !$matcher instanceof RequestMatcherInterface) {
            throw new \InvalidArgumentException('Matcher must implement RequestMatcherInterface.');
        }

>>>>>>> web and vendor directory from composer install
        $this->profiler = $profiler;
        $this->matcher = $matcher;
        $this->onlyException = (bool) $onlyException;
        $this->onlyMasterRequests = (bool) $onlyMasterRequests;
        $this->profiles = new \SplObjectStorage();
        $this->parents = new \SplObjectStorage();
        $this->requestStack = $requestStack;
    }

    /**
     * Handles the onKernelException event.
<<<<<<< HEAD
=======
     *
     * @param GetResponseForExceptionEvent $event A GetResponseForExceptionEvent instance
>>>>>>> web and vendor directory from composer install
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($this->onlyMasterRequests && !$event->isMasterRequest()) {
            return;
        }

        $this->exception = $event->getException();
    }

    /**
<<<<<<< HEAD
     * Handles the onKernelResponse event.
=======
     * @deprecated since version 2.4, to be removed in 3.0.
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (null === $this->requestStack) {
            $this->requests[] = $event->getRequest();
        }
    }

    /**
     * Handles the onKernelResponse event.
     *
     * @param FilterResponseEvent $event A FilterResponseEvent instance
>>>>>>> web and vendor directory from composer install
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $master = $event->isMasterRequest();
        if ($this->onlyMasterRequests && !$master) {
            return;
        }

        if ($this->onlyException && null === $this->exception) {
            return;
        }

        $request = $event->getRequest();
        $exception = $this->exception;
        $this->exception = null;

        if (null !== $this->matcher && !$this->matcher->matches($request)) {
            return;
        }

        if (!$profile = $this->profiler->collect($request, $event->getResponse(), $exception)) {
            return;
        }

        $this->profiles[$request] = $profile;

<<<<<<< HEAD
        $this->parents[$request] = $this->requestStack->getParentRequest();
=======
        if (null !== $this->requestStack) {
            $this->parents[$request] = $this->requestStack->getParentRequest();
        } elseif (!$master) {
            // to be removed when requestStack is required
            array_pop($this->requests);

            $this->parents[$request] = end($this->requests);
        }
>>>>>>> web and vendor directory from composer install
    }

    public function onKernelTerminate(PostResponseEvent $event)
    {
        // attach children to parents
        foreach ($this->profiles as $request) {
<<<<<<< HEAD
            if (null !== $parentRequest = $this->parents[$request]) {
=======
            // isset call should be removed when requestStack is required
            if (isset($this->parents[$request]) && null !== $parentRequest = $this->parents[$request]) {
>>>>>>> web and vendor directory from composer install
                if (isset($this->profiles[$parentRequest])) {
                    $this->profiles[$parentRequest]->addChild($this->profiles[$request]);
                }
            }
        }

        // save profiles
        foreach ($this->profiles as $request) {
            $this->profiler->saveProfile($this->profiles[$request]);
        }

        $this->profiles = new \SplObjectStorage();
        $this->parents = new \SplObjectStorage();
<<<<<<< HEAD
=======
        $this->requests = array();
>>>>>>> web and vendor directory from composer install
    }

    public static function getSubscribedEvents()
    {
        return array(
<<<<<<< HEAD
=======
            // kernel.request must be registered as early as possible to not break
            // when an exception is thrown in any other kernel.request listener
            KernelEvents::REQUEST => array('onKernelRequest', 1024),
>>>>>>> web and vendor directory from composer install
            KernelEvents::RESPONSE => array('onKernelResponse', -100),
            KernelEvents::EXCEPTION => 'onKernelException',
            KernelEvents::TERMINATE => array('onKernelTerminate', -1024),
        );
    }
}
