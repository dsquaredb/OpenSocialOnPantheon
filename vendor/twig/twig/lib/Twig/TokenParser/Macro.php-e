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

/**
 * Defines a macro.
 *
 * <pre>
 * {% macro input(name, value, type, size) %}
 *    <input type="{{ type|default('text') }}" name="{{ name }}" value="{{ value|e }}" size="{{ size|default(20) }}" />
 * {% endmacro %}
 * </pre>
<<<<<<< HEAD
 *
 * @final
=======
>>>>>>> web and vendor directory from composer install
 */
class Twig_TokenParser_Macro extends Twig_TokenParser
{
    public function parse(Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $stream->expect(Twig_Token::NAME_TYPE)->getValue();

        $arguments = $this->parser->getExpressionParser()->parseArguments(true, true);

        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        $this->parser->pushLocalScope();
        $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
        if ($token = $stream->nextIf(Twig_Token::NAME_TYPE)) {
            $value = $token->getValue();

            if ($value != $name) {
<<<<<<< HEAD
                throw new Twig_Error_Syntax(sprintf('Expected endmacro for macro "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext());
=======
                throw new Twig_Error_Syntax(sprintf('Expected endmacro for macro "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext()->getName());
>>>>>>> web and vendor directory from composer install
            }
        }
        $this->parser->popLocalScope();
        $stream->expect(Twig_Token::BLOCK_END_TYPE);

        $this->parser->setMacro($name, new Twig_Node_Macro($name, new Twig_Node_Body(array($body)), $arguments, $lineno, $this->getTag()));
    }

    public function decideBlockEnd(Twig_Token $token)
    {
        return $token->test('endmacro');
    }

    public function getTag()
    {
        return 'macro';
    }
}
<<<<<<< HEAD

class_alias('Twig_TokenParser_Macro', 'Twig\TokenParser\MacroTokenParser', false);
=======
>>>>>>> web and vendor directory from composer install
