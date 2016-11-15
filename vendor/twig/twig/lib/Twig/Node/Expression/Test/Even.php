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
 * Checks if a number is even.
 *
 * <pre>
 *  {{ var is even }}
 * </pre>
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Twig_Node_Expression_Test_Even extends Twig_Node_Expression_Test
{
    public function compile(Twig_Compiler $compiler)
    {
        $compiler
            ->raw('(')
            ->subcompile($this->getNode('node'))
            ->raw(' % 2 == 0')
            ->raw(')')
        ;
    }
}
<<<<<<< HEAD

class_alias('Twig_Node_Expression_Test_Even', 'Twig\Node\Expression\Test\EvenTest', false);
=======
>>>>>>> web and vendor directory from composer install
