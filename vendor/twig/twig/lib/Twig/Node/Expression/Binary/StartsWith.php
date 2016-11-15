<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) Fabien Potencier
=======
 * (c) 2013 Fabien Potencier
>>>>>>> web and vendor directory from composer install
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_Node_Expression_Binary_StartsWith extends Twig_Node_Expression_Binary
{
    public function compile(Twig_Compiler $compiler)
    {
        $left = $compiler->getVarName();
        $right = $compiler->getVarName();
        $compiler
            ->raw(sprintf('(is_string($%s = ', $left))
            ->subcompile($this->getNode('left'))
            ->raw(sprintf(') && is_string($%s = ', $right))
            ->subcompile($this->getNode('right'))
            ->raw(sprintf(') && (\'\' === $%2$s || 0 === strpos($%1$s, $%2$s)))', $left, $right))
        ;
    }

    public function operator(Twig_Compiler $compiler)
    {
        return $compiler->raw('');
    }
}
<<<<<<< HEAD

class_alias('Twig_Node_Expression_Binary_StartsWith', 'Twig\Node\Expression\Binary\StartsWithBinary', false);
=======
>>>>>>> web and vendor directory from composer install
