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
class Twig_Node_Expression_Binary_Or extends Twig_Node_Expression_Binary
{
    public function operator(Twig_Compiler $compiler)
    {
        return $compiler->raw('||');
    }
}
<<<<<<< HEAD

class_alias('Twig_Node_Expression_Binary_Or', 'Twig\Node\Expression\Binary\OrBinary', false);
=======
>>>>>>> web and vendor directory from composer install
