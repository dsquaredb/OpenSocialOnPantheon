<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) Fabien Potencier
=======
 * (c) 2016 Fabien Potencier
>>>>>>> web and vendor directory from composer install
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Adds a getSourceContext() method for loaders.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @deprecated since 1.27 (to be removed in 3.0)
 */
interface Twig_SourceContextLoaderInterface
{
    /**
     * Returns the source context for a given template logical name.
     *
     * @param string $name The template logical name
     *
     * @return Twig_Source
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getSourceContext($name);
}
<<<<<<< HEAD

class_alias('Twig_SourceContextLoaderInterface', 'Twig\Loader\SourceContextLoaderInterface', false);
=======
>>>>>>> web and vendor directory from composer install
