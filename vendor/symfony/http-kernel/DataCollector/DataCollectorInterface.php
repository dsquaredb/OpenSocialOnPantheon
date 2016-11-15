<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * DataCollectorInterface.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
 *
 * @method reset() Resets this data collector to its initial state.
=======
>>>>>>> web and vendor directory from composer install
 */
interface DataCollectorInterface
{
    /**
     * Collects data for the given Request and Response.
<<<<<<< HEAD
=======
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An Exception instance
>>>>>>> web and vendor directory from composer install
     */
    public function collect(Request $request, Response $response, \Exception $exception = null);

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName();
}
