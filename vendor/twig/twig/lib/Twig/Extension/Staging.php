<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) Fabien Potencier
=======
 * (c) 2012 Fabien Potencier
>>>>>>> web and vendor directory from composer install
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Internal class.
 *
 * This class is used by Twig_Environment as a staging area and must not be used directly.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
class Twig_Extension_Staging extends Twig_Extension
{
    protected $functions = array();
    protected $filters = array();
    protected $visitors = array();
    protected $tokenParsers = array();
    protected $globals = array();
    protected $tests = array();

    public function addFunction($name, $function)
    {
<<<<<<< HEAD
        if (isset($this->functions[$name])) {
            @trigger_error(sprintf('Overriding function "%s" that is already registered is deprecated since version 1.30 and won\'t be possible anymore in 2.0.', $name), E_USER_DEPRECATED);
        }

=======
>>>>>>> web and vendor directory from composer install
        $this->functions[$name] = $function;
    }

    public function getFunctions()
    {
        return $this->functions;
    }

    public function addFilter($name, $filter)
    {
<<<<<<< HEAD
        if (isset($this->filters[$name])) {
            @trigger_error(sprintf('Overriding filter "%s" that is already registered is deprecated since version 1.30 and won\'t be possible anymore in 2.0.', $name), E_USER_DEPRECATED);
        }

=======
>>>>>>> web and vendor directory from composer install
        $this->filters[$name] = $filter;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function addNodeVisitor(Twig_NodeVisitorInterface $visitor)
    {
        $this->visitors[] = $visitor;
    }

    public function getNodeVisitors()
    {
        return $this->visitors;
    }

    public function addTokenParser(Twig_TokenParserInterface $parser)
    {
<<<<<<< HEAD
        if (isset($this->tokenParsers[$parser->getTag()])) {
            @trigger_error(sprintf('Overriding tag "%s" that is already registered is deprecated since version 1.30 and won\'t be possible anymore in 2.0.', $parser->getTag()), E_USER_DEPRECATED);
        }

        $this->tokenParsers[$parser->getTag()] = $parser;
=======
        $this->tokenParsers[] = $parser;
>>>>>>> web and vendor directory from composer install
    }

    public function getTokenParsers()
    {
        return $this->tokenParsers;
    }

    public function addGlobal($name, $value)
    {
        $this->globals[$name] = $value;
    }

    public function getGlobals()
    {
        return $this->globals;
    }

    public function addTest($name, $test)
    {
<<<<<<< HEAD
        if (isset($this->tests[$name])) {
            @trigger_error(sprintf('Overriding test "%s" that is already registered is deprecated since version 1.30 and won\'t be possible anymore in 2.0.', $name), E_USER_DEPRECATED);
        }

=======
>>>>>>> web and vendor directory from composer install
        $this->tests[$name] = $test;
    }

    public function getTests()
    {
        return $this->tests;
    }

    public function getName()
    {
        return 'staging';
    }
}
<<<<<<< HEAD

class_alias('Twig_Extension_Staging', 'Twig\Extension\StagingExtension', false);
=======
>>>>>>> web and vendor directory from composer install
