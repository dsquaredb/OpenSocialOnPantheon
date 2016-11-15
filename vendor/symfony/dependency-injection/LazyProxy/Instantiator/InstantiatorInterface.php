<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\LazyProxy\Instantiator;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Lazy proxy instantiator, capable of instantiating a proxy given a container, the
 * service definitions and a callback that produces the real service instance.
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
interface InstantiatorInterface
{
    /**
     * Instantiates a proxy object.
     *
<<<<<<< HEAD
     * @param ContainerInterface $container        The container from which the service is being requested
     * @param Definition         $definition       The definition of the requested service
     * @param string             $id               Identifier of the requested service
     * @param callable           $realInstantiator Zero-argument callback that is capable of producing the real service instance
=======
     * @param ContainerInterface $container        the container from which the service is being requested
     * @param Definition         $definition       the definition of the requested service
     * @param string             $id               identifier of the requested service
     * @param callable           $realInstantiator zero-argument callback that is capable of producing the real
     *                                             service instance
>>>>>>> web and vendor directory from composer install
     *
     * @return object
     */
    public function instantiateProxy(ContainerInterface $container, Definition $definition, $id, $realInstantiator);
}
