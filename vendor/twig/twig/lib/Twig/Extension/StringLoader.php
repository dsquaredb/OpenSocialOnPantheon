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
<<<<<<< HEAD

/**
 * @final
 */
=======
>>>>>>> web and vendor directory from composer install
class Twig_Extension_StringLoader extends Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('template_from_string', 'twig_template_from_string', array('needs_environment' => true)),
        );
    }

    public function getName()
    {
        return 'string_loader';
    }
}

/**
 * Loads a template from a string.
 *
 * <pre>
 * {{ include(template_from_string("Hello {{ name }}")) }}
 * </pre>
 *
 * @param Twig_Environment $env      A Twig_Environment instance
 * @param string           $template A template as a string or object implementing __toString()
 *
<<<<<<< HEAD
 * @return Twig_Template
=======
 * @return Twig_Template A Twig_Template instance
>>>>>>> web and vendor directory from composer install
 */
function twig_template_from_string(Twig_Environment $env, $template)
{
    return $env->createTemplate((string) $template);
}
<<<<<<< HEAD

class_alias('Twig_Extension_StringLoader', 'Twig\Extension\StringLoaderExtension', false);
=======
>>>>>>> web and vendor directory from composer install
