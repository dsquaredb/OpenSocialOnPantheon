<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) Fabien Potencier
=======
 * (c) 2011 Fabien Potencier
>>>>>>> web and vendor directory from composer install
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Loads templates from other loaders.
 *
<<<<<<< HEAD
 * @final
 *
=======
>>>>>>> web and vendor directory from composer install
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Twig_Loader_Chain implements Twig_LoaderInterface, Twig_ExistsLoaderInterface, Twig_SourceContextLoaderInterface
{
    private $hasSourceCache = array();
    protected $loaders = array();

    /**
<<<<<<< HEAD
     * @param Twig_LoaderInterface[] $loaders
=======
     * Constructor.
     *
     * @param Twig_LoaderInterface[] $loaders An array of loader instances
>>>>>>> web and vendor directory from composer install
     */
    public function __construct(array $loaders = array())
    {
        foreach ($loaders as $loader) {
            $this->addLoader($loader);
        }
    }

<<<<<<< HEAD
=======
    /**
     * Adds a loader instance.
     *
     * @param Twig_LoaderInterface $loader A Loader instance
     */
>>>>>>> web and vendor directory from composer install
    public function addLoader(Twig_LoaderInterface $loader)
    {
        $this->loaders[] = $loader;
        $this->hasSourceCache = array();
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> web and vendor directory from composer install
    public function getSource($name)
    {
        @trigger_error(sprintf('Calling "getSource" on "%s" is deprecated since 1.27. Use getSourceContext() instead.', get_class($this)), E_USER_DEPRECATED);

        $exceptions = array();
        foreach ($this->loaders as $loader) {
            if ($loader instanceof Twig_ExistsLoaderInterface && !$loader->exists($name)) {
                continue;
            }

            try {
                return $loader->getSource($name);
            } catch (Twig_Error_Loader $e) {
                $exceptions[] = $e->getMessage();
            }
        }

        throw new Twig_Error_Loader(sprintf('Template "%s" is not defined%s.', $name, $exceptions ? ' ('.implode(', ', $exceptions).')' : ''));
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> web and vendor directory from composer install
    public function getSourceContext($name)
    {
        $exceptions = array();
        foreach ($this->loaders as $loader) {
            if ($loader instanceof Twig_ExistsLoaderInterface && !$loader->exists($name)) {
                continue;
            }

            try {
                if ($loader instanceof Twig_SourceContextLoaderInterface) {
                    return $loader->getSourceContext($name);
                }

                return new Twig_Source($loader->getSource($name), $name);
            } catch (Twig_Error_Loader $e) {
                $exceptions[] = $e->getMessage();
            }
        }

        throw new Twig_Error_Loader(sprintf('Template "%s" is not defined%s.', $name, $exceptions ? ' ('.implode(', ', $exceptions).')' : ''));
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> web and vendor directory from composer install
    public function exists($name)
    {
        $name = (string) $name;

        if (isset($this->hasSourceCache[$name])) {
            return $this->hasSourceCache[$name];
        }

        foreach ($this->loaders as $loader) {
            if ($loader instanceof Twig_ExistsLoaderInterface) {
                if ($loader->exists($name)) {
                    return $this->hasSourceCache[$name] = true;
                }

                continue;
            }

            try {
                if ($loader instanceof Twig_SourceContextLoaderInterface) {
                    $loader->getSourceContext($name);
                } else {
                    $loader->getSource($name);
                }

                return $this->hasSourceCache[$name] = true;
            } catch (Twig_Error_Loader $e) {
            }
        }

        return $this->hasSourceCache[$name] = false;
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> web and vendor directory from composer install
    public function getCacheKey($name)
    {
        $exceptions = array();
        foreach ($this->loaders as $loader) {
            if ($loader instanceof Twig_ExistsLoaderInterface && !$loader->exists($name)) {
                continue;
            }

            try {
                return $loader->getCacheKey($name);
            } catch (Twig_Error_Loader $e) {
                $exceptions[] = get_class($loader).': '.$e->getMessage();
            }
        }

        throw new Twig_Error_Loader(sprintf('Template "%s" is not defined%s.', $name, $exceptions ? ' ('.implode(', ', $exceptions).')' : ''));
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> web and vendor directory from composer install
    public function isFresh($name, $time)
    {
        $exceptions = array();
        foreach ($this->loaders as $loader) {
            if ($loader instanceof Twig_ExistsLoaderInterface && !$loader->exists($name)) {
                continue;
            }

            try {
                return $loader->isFresh($name, $time);
            } catch (Twig_Error_Loader $e) {
                $exceptions[] = get_class($loader).': '.$e->getMessage();
            }
        }

        throw new Twig_Error_Loader(sprintf('Template "%s" is not defined%s.', $name, $exceptions ? ' ('.implode(', ', $exceptions).')' : ''));
    }
}
<<<<<<< HEAD

class_alias('Twig_Loader_Chain', 'Twig\Loader\ChainLoader', false);
=======
>>>>>>> web and vendor directory from composer install
