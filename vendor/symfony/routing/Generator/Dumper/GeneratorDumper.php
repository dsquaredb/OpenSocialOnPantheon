<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Generator\Dumper;

use Symfony\Component\Routing\RouteCollection;

/**
 * GeneratorDumper is the base class for all built-in generator dumpers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class GeneratorDumper implements GeneratorDumperInterface
{
<<<<<<< HEAD
    private $routes;

=======
    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * Constructor.
     *
     * @param RouteCollection $routes The RouteCollection to dump
     */
>>>>>>> web and vendor directory from composer install
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}
