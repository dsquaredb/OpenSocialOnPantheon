<?php

/*
 * This file is part of Twig.
 *
 
 * (c) Fabien Potencier
=======
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 

abstract class Twig_Extension implements Twig_ExtensionInterface
{
    /**
=======
abstract class Twig_Extension implements Twig_ExtensionInterface
{
    /**
     * {@inheritdoc}
     *
     * @deprecated since 1.23 (to be removed in 2.0), implement Twig_Extension_InitRuntimeInterface instead
     */
    public function initRuntime(Twig_Environment $environment)
    {
    }

 
=======
    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return array();
    }

 
=======
    /**
     * {@inheritdoc}
     */
    public function getNodeVisitors()
    {
        return array();
    }

 
=======
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array();
    }

 
=======
    /**
     * {@inheritdoc}
     */
    public function getTests()
    {
        return array();
    }

 
=======
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array();
    }

 
=======
    /**
     * {@inheritdoc}
     */
    public function getOperators()
    {
        return array();
    }

    /**
 
=======
     * {@inheritdoc}
     *
     * @deprecated since 1.23 (to be removed in 2.0), implement Twig_Extension_GlobalsInterface instead
     */
    public function getGlobals()
    {
        return array();
    }

    /**
 
=======
     * {@inheritdoc}
     *
     * @deprecated since 1.26 (to be removed in 2.0), not used anymore internally
     */
    public function getName()
    {
        return get_class($this);
    }
}
 

class_alias('Twig_Extension', 'Twig\Extension\AbstractExtension', false);
class_exists('Twig_Environment');
=======
