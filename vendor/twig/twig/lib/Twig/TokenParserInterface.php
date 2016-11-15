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
 * Interface implemented by token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface Twig_TokenParserInterface
{
    /**
     * Sets the parser associated with this token parser.
<<<<<<< HEAD
=======
     *
     * @param Twig_Parser $parser A Twig_Parser instance
>>>>>>> web and vendor directory from composer install
     */
    public function setParser(Twig_Parser $parser);

    /**
     * Parses a token and returns a node.
     *
<<<<<<< HEAD
     * @return Twig_NodeInterface
=======
     * @param Twig_Token $token A Twig_Token instance
     *
     * @return Twig_NodeInterface A Twig_NodeInterface instance
>>>>>>> web and vendor directory from composer install
     *
     * @throws Twig_Error_Syntax
     */
    public function parse(Twig_Token $token);

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag();
}
<<<<<<< HEAD

class_alias('Twig_TokenParserInterface', 'Twig\TokenParser\TokenParserInterface', false);
class_exists('Twig_Parser');
class_exists('Twig_Token');
=======
>>>>>>> web and vendor directory from composer install
