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

/**
 * Represents a node in the AST.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @deprecated since 1.12 (to be removed in 3.0)
 */
interface Twig_NodeInterface extends Countable, IteratorAggregate
{
    /**
     * Compiles the node to PHP.
<<<<<<< HEAD
=======
     *
     * @param Twig_Compiler $compiler A Twig_Compiler instance
>>>>>>> web and vendor directory from composer install
     */
    public function compile(Twig_Compiler $compiler);

    /**
     * @deprecated since 1.27 (to be removed in 2.0)
     */
    public function getLine();

    public function getNodeTag();
}
