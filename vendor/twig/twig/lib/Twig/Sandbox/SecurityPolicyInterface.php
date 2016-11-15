<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) Fabien Potencier
=======
 * (c) 2009 Fabien Potencier
>>>>>>> web and vendor directory from composer install
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Interfaces that all security policy classes must implements.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface Twig_Sandbox_SecurityPolicyInterface
{
    public function checkSecurity($tags, $filters, $functions);

    public function checkMethodAllowed($obj, $method);

    public function checkPropertyAllowed($obj, $method);
}
<<<<<<< HEAD

class_alias('Twig_Sandbox_SecurityPolicyInterface', 'Twig\Sandbox\SecurityPolicyInterface', false);
=======
>>>>>>> web and vendor directory from composer install
