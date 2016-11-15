<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console;

/**
 * Contains all events dispatched by an Application.
 *
 * @author Francesco Levorato <git@flevour.net>
 */
final class ConsoleEvents
{
    /**
     * The COMMAND event allows you to attach listeners before any command is
     * executed by the console. It also allows you to modify the command, input and output
     * before they are handled to the command.
     *
<<<<<<< HEAD
     * @Event("Symfony\Component\Console\Event\ConsoleCommandEvent")
=======
     * The event listener method receives a Symfony\Component\Console\Event\ConsoleCommandEvent
     * instance.
     *
     * @Event
     *
     * @var string
>>>>>>> web and vendor directory from composer install
     */
    const COMMAND = 'console.command';

    /**
     * The TERMINATE event allows you to attach listeners after a command is
     * executed by the console.
     *
<<<<<<< HEAD
     * @Event("Symfony\Component\Console\Event\ConsoleTerminateEvent")
=======
     * The event listener method receives a Symfony\Component\Console\Event\ConsoleTerminateEvent
     * instance.
     *
     * @Event
     *
     * @var string
>>>>>>> web and vendor directory from composer install
     */
    const TERMINATE = 'console.terminate';

    /**
<<<<<<< HEAD
     * The EXCEPTION event occurs when an uncaught exception appears
     * while executing Command#run().
     *
     * This event allows you to deal with the exception or
     * to modify the thrown exception.
     *
     * @Event("Symfony\Component\Console\Event\ConsoleExceptionEvent")
     *
     * @deprecated The console.exception event is deprecated since version 3.3 and will be removed in 4.0. Use the console.error event instead.
     */
    const EXCEPTION = 'console.exception';

    /**
     * The ERROR event occurs when an uncaught exception or error appears.
     *
     * This event allows you to deal with the exception/error or
     * to modify the thrown exception.
     *
     * @Event("Symfony\Component\Console\Event\ConsoleErrorEvent")
     */
    const ERROR = 'console.error';
=======
     * The EXCEPTION event occurs when an uncaught exception appears.
     *
     * This event allows you to deal with the exception or
     * to modify the thrown exception. The event listener method receives
     * a Symfony\Component\Console\Event\ConsoleExceptionEvent
     * instance.
     *
     * @Event
     *
     * @var string
     */
    const EXCEPTION = 'console.exception';
>>>>>>> web and vendor directory from composer install
}
