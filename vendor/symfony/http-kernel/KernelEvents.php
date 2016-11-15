<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel;

/**
 * Contains all events thrown in the HttpKernel component.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
final class KernelEvents
{
    /**
     * The REQUEST event occurs at the very beginning of request
     * dispatching.
     *
     * This event allows you to create a response for a request before any
<<<<<<< HEAD
     * other code in the framework is executed.
     *
     * @Event("Symfony\Component\HttpKernel\Event\GetResponseEvent")
=======
     * other code in the framework is executed. The event listener method
     * receives a Symfony\Component\HttpKernel\Event\GetResponseEvent
     * instance.
     *
     * @Event
     *
     * @var string
>>>>>>> web and vendor directory from composer install
     */
    const REQUEST = 'kernel.request';

    /**
     * The EXCEPTION event occurs when an uncaught exception appears.
     *
     * This event allows you to create a response for a thrown exception or
<<<<<<< HEAD
     * to modify the thrown exception.
     *
     * @Event("Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent")
=======
     * to modify the thrown exception. The event listener method receives
     * a Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent
     * instance.
     *
     * @Event
     *
     * @var string
>>>>>>> web and vendor directory from composer install
     */
    const EXCEPTION = 'kernel.exception';

    /**
     * The VIEW event occurs when the return value of a controller
     * is not a Response instance.
     *
     * This event allows you to create a response for the return value of the
<<<<<<< HEAD
     * controller.
     *
     * @Event("Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent")
=======
     * controller. The event listener method receives a
     * Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent
     * instance.
     *
     * @Event
     *
     * @var string
>>>>>>> web and vendor directory from composer install
     */
    const VIEW = 'kernel.view';

    /**
     * The CONTROLLER event occurs once a controller was found for
     * handling a request.
     *
     * This event allows you to change the controller that will handle the
<<<<<<< HEAD
     * request.
     *
     * @Event("Symfony\Component\HttpKernel\Event\FilterControllerEvent")
     */
    const CONTROLLER = 'kernel.controller';

    /**
     * The CONTROLLER_ARGUMENTS event occurs once controller arguments have been resolved.
     *
     * This event allows you to change the arguments that will be passed to
     * the controller.
     *
     * @Event("Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent")
     */
    const CONTROLLER_ARGUMENTS = 'kernel.controller_arguments';
=======
     * request. The event listener method receives a
     * Symfony\Component\HttpKernel\Event\FilterControllerEvent instance.
     *
     * @Event
     *
     * @var string
     */
    const CONTROLLER = 'kernel.controller';
>>>>>>> web and vendor directory from composer install

    /**
     * The RESPONSE event occurs once a response was created for
     * replying to a request.
     *
     * This event allows you to modify or replace the response that will be
<<<<<<< HEAD
     * replied.
     *
     * @Event("Symfony\Component\HttpKernel\Event\FilterResponseEvent")
=======
     * replied. The event listener method receives a
     * Symfony\Component\HttpKernel\Event\FilterResponseEvent instance.
     *
     * @Event
     *
     * @var string
>>>>>>> web and vendor directory from composer install
     */
    const RESPONSE = 'kernel.response';

    /**
     * The TERMINATE event occurs once a response was sent.
     *
     * This event allows you to run expensive post-response jobs.
<<<<<<< HEAD
     *
     * @Event("Symfony\Component\HttpKernel\Event\PostResponseEvent")
=======
     * The event listener method receives a
     * Symfony\Component\HttpKernel\Event\PostResponseEvent instance.
     *
     * @Event
     *
     * @var string
>>>>>>> web and vendor directory from composer install
     */
    const TERMINATE = 'kernel.terminate';

    /**
     * The FINISH_REQUEST event occurs when a response was generated for a request.
     *
     * This event allows you to reset the global and environmental state of
     * the application, when it was changed during the request.
<<<<<<< HEAD
     *
     * @Event("Symfony\Component\HttpKernel\Event\FinishRequestEvent")
=======
     * The event listener method receives a
     * Symfony\Component\HttpKernel\Event\FinishRequestEvent instance.
     *
     * @Event
     *
     * @var string
>>>>>>> web and vendor directory from composer install
     */
    const FINISH_REQUEST = 'kernel.finish_request';
}
