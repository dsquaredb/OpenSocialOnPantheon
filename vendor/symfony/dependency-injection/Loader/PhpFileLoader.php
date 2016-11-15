<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader;

<<<<<<< HEAD
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
=======
use Symfony\Component\Config\Resource\FileResource;
>>>>>>> web and vendor directory from composer install

/**
 * PhpFileLoader loads service definitions from a PHP file.
 *
 * The PHP file is required and the $container variable can be
 * used within the file to change the container.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class PhpFileLoader extends FileLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        // the container and loader variables are exposed to the included file below
        $container = $this->container;
        $loader = $this;

        $path = $this->locator->locate($resource);
        $this->setCurrentDir(dirname($path));
<<<<<<< HEAD
        $this->container->fileExists($path);

        // the closure forbids access to the private scope in the included file
        $load = \Closure::bind(function ($path) use ($container, $loader, $resource, $type) {
            return include $path;
        }, $this, ProtectedPhpFileLoader::class);

        $callback = $load($path);

        if ($callback instanceof \Closure) {
            $callback(new ContainerConfigurator($this->container, $this, $this->instanceof, $path, $resource), $this->container, $this);
        }
=======
        $this->container->addResource(new FileResource($path));

        include $path;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
<<<<<<< HEAD
        if (!is_string($resource)) {
            return false;
        }

        if (null === $type && 'php' === pathinfo($resource, PATHINFO_EXTENSION)) {
            return true;
        }

        return 'php' === $type;
    }
}

/**
 * @internal
 */
final class ProtectedPhpFileLoader extends PhpFileLoader
{
}
=======
        return is_string($resource) && 'php' === pathinfo($resource, PATHINFO_EXTENSION);
    }
}
>>>>>>> web and vendor directory from composer install
