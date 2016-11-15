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

/**
 * Extends a template by another one.
 *
 * <pre>
 *  {% extends "base.html" %}
 * </pre>
<<<<<<< HEAD
 *
 * @final
=======
>>>>>>> web and vendor directory from composer install
 */
class Twig_TokenParser_Extends extends Twig_TokenParser
{
    public function parse(Twig_Token $token)
    {
        $stream = $this->parser->getStream();

        if (!$this->parser->isMainScope()) {
<<<<<<< HEAD
            throw new Twig_Error_Syntax('Cannot extend from a block.', $token->getLine(), $stream->getSourceContext());
        }

        if (null !== $this->parser->getParent()) {
            throw new Twig_Error_Syntax('Multiple extends tags are forbidden.', $token->getLine(), $stream->getSourceContext());
=======
            throw new Twig_Error_Syntax('Cannot extend from a block.', $token->getLine(), $stream->getSourceContext()->getName());
        }

        if (null !== $this->parser->getParent()) {
            throw new Twig_Error_Syntax('Multiple extends tags are forbidden.', $token->getLine(), $stream->getSourceContext()->getName());
>>>>>>> web and vendor directory from composer install
        }
        $this->parser->setParent($this->parser->getExpressionParser()->parseExpression());

        $stream->expect(Twig_Token::BLOCK_END_TYPE);
    }

    public function getTag()
    {
        return 'extends';
    }
}
<<<<<<< HEAD

class_alias('Twig_TokenParser_Extends', 'Twig\TokenParser\ExtendsTokenParser', false);
=======
>>>>>>> web and vendor directory from composer install
