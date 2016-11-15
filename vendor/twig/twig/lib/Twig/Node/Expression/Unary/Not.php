<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) Fabien Potencier
 * (c) Armin Ronacher
=======
 * (c) 2009 Fabien Potencier
 * (c) 2009 Armin Ronacher
>>>>>>> web and vendor directory from composer install
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_Node_Expression_Unary_Not extends Twig_Node_Expression_Unary
{
    public function operator(Twig_Compiler $compiler)
    {
        $compiler->raw('!');
    }
}
<<<<<<< HEAD

class_alias('Twig_Node_Expression_Unary_Not', 'Twig\Node\Expression\Unary\NotUnary', false);
=======
>>>>>>> web and vendor directory from composer install
