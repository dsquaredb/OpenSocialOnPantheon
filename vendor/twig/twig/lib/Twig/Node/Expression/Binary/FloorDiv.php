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
class Twig_Node_Expression_Binary_FloorDiv extends Twig_Node_Expression_Binary
{
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->raw('(int) floor(');
        parent::compile($compiler);
        $compiler->raw(')');
    }

    public function operator(Twig_Compiler $compiler)
    {
        return $compiler->raw('/');
    }
}
<<<<<<< HEAD

class_alias('Twig_Node_Expression_Binary_FloorDiv', 'Twig\Node\Expression\Binary\FloorDivBinary', false);
=======
>>>>>>> web and vendor directory from composer install
