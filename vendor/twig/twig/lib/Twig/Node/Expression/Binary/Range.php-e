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
class Twig_Node_Expression_Binary_Range extends Twig_Node_Expression_Binary
{
    public function compile(Twig_Compiler $compiler)
    {
        $compiler
            ->raw('range(')
            ->subcompile($this->getNode('left'))
            ->raw(', ')
            ->subcompile($this->getNode('right'))
            ->raw(')')
        ;
    }

    public function operator(Twig_Compiler $compiler)
    {
        return $compiler->raw('..');
    }
}
<<<<<<< HEAD

class_alias('Twig_Node_Expression_Binary_Range', 'Twig\Node\Expression\Binary\RangeBinary', false);
=======
>>>>>>> web and vendor directory from composer install
