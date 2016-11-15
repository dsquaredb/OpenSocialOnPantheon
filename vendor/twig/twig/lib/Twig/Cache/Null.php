<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) Fabien Potencier
=======
 * (c) 2015 Fabien Potencier
>>>>>>> web and vendor directory from composer install
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Implements a no-cache strategy.
 *
<<<<<<< HEAD
 * @final
 *
=======
>>>>>>> web and vendor directory from composer install
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Twig_Cache_Null implements Twig_CacheInterface
{
<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> web and vendor directory from composer install
    public function generateKey($name, $className)
    {
        return '';
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> web and vendor directory from composer install
    public function write($key, $content)
    {
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> web and vendor directory from composer install
    public function load($key)
    {
    }

<<<<<<< HEAD
=======
    /**
     * {@inheritdoc}
     */
>>>>>>> web and vendor directory from composer install
    public function getTimestamp($key)
    {
        return 0;
    }
}
<<<<<<< HEAD

class_alias('Twig_Cache_Null', 'Twig\Cache\NullCache', false);
=======
>>>>>>> web and vendor directory from composer install
