<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) Fabien Potencier
=======
 * (c) 2010 Fabien Potencier
>>>>>>> web and vendor directory from composer install
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_Node_Expression_Binary_GreaterEqual extends Twig_Node_Expression_Binary
{
    public function operator(Twig_Compiler $compiler)
    {
        return $compiler->raw('>=');
    }
}
<<<<<<< HEAD

class_alias('Twig_Node_Expression_Binary_GreaterEqual', 'Twig\Node\Expression\Binary\GreaterEqualBinary', false);
=======
>>>>>>> web and vendor directory from composer install
