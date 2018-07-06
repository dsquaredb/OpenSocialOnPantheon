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

use Psr\Log\LoggerInterface;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
use Symfony\Component\Debug\ExceptionHandler;
=======
>>>>>>> Update Open Social to 8.x-2.1
=======
use Symfony\Component\Debug\ExceptionHandler;
>>>>>>> revert Open Social update
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
=======
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
>>>>>>> web and vendor directory from composer install
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * ExceptionListener.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ExceptionListener implements EventSubscriberInterface
{
    protected $controller;
    protected $logger;
<<<<<<< HEAD
    protected $debug;
    private $charset;

    public function __construct($controller, LoggerInterface $logger = null, $debug = false, $charset = null)
    {
        $this->controller = $controller;
        $this->logger = $logger;
        $this->debug = $debug;
<<<<<<< HEAD
<<<<<<< HEAD
        $this->charset = $charset;
=======

    public function __construct($controller, LoggerInterface $logger = null)
    {
        $this->controller = $controller;
        $this->logger = $logger;
>>>>>>> web and vendor directory from composer install
=======
>>>>>>> Update Open Social to 8.x-2.1
=======
        $this->charset = $charset;
>>>>>>> revert Open Social update
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $request = $event->getRequest();
<<<<<<< HEAD
        $eventDispatcher = func_num_args() > 2 ? func_get_arg(2) : null;
=======
>>>>>>> web and vendor directory from composer install

        $this->logException($exception, sprintf('Uncaught PHP Exception %s: "%s" at %s line %s', get_class($exception), $exception->getMessage(), $exception->getFile(), $exception->getLine()));

        $request = $this->duplicateRequest($exception, $request);

        try {
            $response = $event->getKernel()->handle($request, HttpKernelInterface::SUB_REQUEST, false);
        } catch (\Exception $e) {
            $this->logException($e, sprintf('Exception thrown when handling an exception (%s: %s at %s line %s)', get_class($e), $e->getMessage(), $e->getFile(), $e->getLine()));

            $wrapper = $e;

            while ($prev = $wrapper->getPrevious()) {
                if ($exception === $wrapper = $prev) {
                    throw $e;
                }
            }

            $prev = new \ReflectionProperty('Exception', 'previous');
            $prev->setAccessible(true);
            $prev->setValue($wrapper, $exception);

            throw $e;
        }

        $event->setResponse($response);
<<<<<<< HEAD

        if ($this->debug && $eventDispatcher instanceof EventDispatcherInterface) {
            $cspRemovalListener = function (FilterResponseEvent $event) use (&$cspRemovalListener, $eventDispatcher) {
                $event->getResponse()->headers->remove('Content-Security-Policy');
                $eventDispatcher->removeListener(KernelEvents::RESPONSE, $cspRemovalListener);
            };
            $eventDispatcher->addListener(KernelEvents::RESPONSE, $cspRemovalListener, -128);
        }
=======
>>>>>>> web and vendor directory from composer install
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array('onKernelException', -128),
        );
    }

    /**
     * Logs an exception.
     *
     * @param \Exception $exception The \Exception instance
     * @param string     $message   The error message to log
     */
    protected function logException(\Exception $exception, $message)
    {
        if (null !== $this->logger) {
            if (!$exception instanceof HttpExceptionInterface || $exception->getStatusCode() >= 500) {
                $this->logger->critical($message, array('exception' => $exception));
            } else {
                $this->logger->error($message, array('exception' => $exception));
            }
        }
    }

    /**
     * Clones the request for the exception.
     *
     * @param \Exception $exception The thrown exception
     * @param Request    $request   The original request
     *
     * @return Request $request The cloned request
     */
    protected function duplicateRequest(\Exception $exception, Request $request)
    {
        $attributes = array(
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> revert Open Social update
            'exception' => $exception = FlattenException::create($exception),
            '_controller' => $this->controller ?: function () use ($exception) {
                $handler = new ExceptionHandler($this->debug, $this->charset);

                return new Response($handler->getHtml($exception), $exception->getStatusCode(), $exception->getHeaders());
            },
<<<<<<< HEAD
=======
            '_controller' => $this->controller,
            'exception' => FlattenException::create($exception),
>>>>>>> Update Open Social to 8.x-2.1
            'logger' => $this->logger instanceof DebugLoggerInterface ? $this->logger : null,
=======
            '_controller' => $this->controller,
            'exception' => FlattenException::create($exception),
=======
>>>>>>> revert Open Social update
            'logger' => $this->logger instanceof DebugLoggerInterface ? $this->logger : null,
            // keep for BC -- as $format can be an argument of the controller callable
            // see src/Symfony/Bundle/TwigBundle/Controller/ExceptionController.php
            // @deprecated since version 2.4, to be removed in 3.0
            'format' => $request->getRequestFormat(),
>>>>>>> web and vendor directory from composer install
        );
        $request = $request->duplicate(null, null, $attributes);
        $request->setMethod('GET');

        return $request;
    }
}
