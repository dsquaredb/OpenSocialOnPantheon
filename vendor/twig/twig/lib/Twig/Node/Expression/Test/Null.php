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
 * Checks that a variable is null.
 *
 * <pre>
 *  {{ var is none }}
 * </pre>
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Twig_Node_Expression_Test_Null extends Twig_Node_Expression_Test
{
    public function compile(Twig_Compiler $compiler)
    {
        $compiler
            ->raw('(null === ')
            ->subcompile($this->getNode('node'))
            ->raw(')')
        ;
    }
}
<<<<<<< HEAD

class_alias('Twig_Node_Expression_Test_Null', 'Twig\Node\Expression\Test\NullTest', false);
=======
>>>>>>> web and vendor directory from composer install
