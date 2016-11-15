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
 * Interface implemented by extension classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface Twig_ExtensionInterface
{
    /**
     * Initializes the runtime environment.
     *
     * This is where you can load some file that contains filter functions for instance.
     *
<<<<<<< HEAD
=======
     * @param Twig_Environment $environment The current Twig_Environment instance
     *
>>>>>>> web and vendor directory from composer install
     * @deprecated since 1.23 (to be removed in 2.0), implement Twig_Extension_InitRuntimeInterface instead
     */
    public function initRuntime(Twig_Environment $environment);

    /**
     * Returns the token parser instances to add to the existing list.
     *
     * @return Twig_TokenParserInterface[]
     */
    public function getTokenParsers();

    /**
     * Returns the node visitor instances to add to the existing list.
     *
<<<<<<< HEAD
     * @return Twig_NodeVisitorInterface[]
=======
     * @return Twig_NodeVisitorInterface[] An array of Twig_NodeVisitorInterface instances
>>>>>>> web and vendor directory from composer install
     */
    public function getNodeVisitors();

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return Twig_SimpleFilter[]
     */
    public function getFilters();

    /**
     * Returns a list of tests to add to the existing list.
     *
     * @return Twig_SimpleTest[]
     */
    public function getTests();

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions();

    /**
     * Returns a list of operators to add to the existing list.
     *
<<<<<<< HEAD
     * @return array<array> First array of unary operators, second array of binary operators
=======
     * @return array An array of operators
>>>>>>> web and vendor directory from composer install
     */
    public function getOperators();

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     *
     * @deprecated since 1.23 (to be removed in 2.0), implement Twig_Extension_GlobalsInterface instead
     */
    public function getGlobals();

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     *
     * @deprecated since 1.26 (to be removed in 2.0), not used anymore internally
     */
    public function getName();
}
<<<<<<< HEAD

class_alias('Twig_ExtensionInterface', 'Twig\Extension\ExtensionInterface', false);
class_exists('Twig_Environment');
=======
>>>>>>> web and vendor directory from composer install
