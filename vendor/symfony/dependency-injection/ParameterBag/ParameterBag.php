<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\ParameterBag;

use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\Exception\ParameterCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * Holds parameters.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ParameterBag implements ParameterBagInterface
{
    protected $parameters = array();
    protected $resolved = false;

<<<<<<< HEAD
    private $normalizedNames = array();

=======
>>>>>>> web and vendor directory from composer install
    /**
     * @param array $parameters An array of parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->add($parameters);
    }

    /**
     * Clears all parameters.
     */
    public function clear()
    {
        $this->parameters = array();
    }

    /**
     * Adds parameters to the service container parameters.
     *
     * @param array $parameters An array of parameters
     */
    public function add(array $parameters)
    {
        foreach ($parameters as $key => $value) {
<<<<<<< HEAD
            $this->set($key, $value);
=======
            $this->parameters[strtolower($key)] = $value;
>>>>>>> web and vendor directory from composer install
        }
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
<<<<<<< HEAD
        $name = $this->normalizeName($name);
=======
        $name = strtolower($name);
>>>>>>> web and vendor directory from composer install

        if (!array_key_exists($name, $this->parameters)) {
            if (!$name) {
                throw new ParameterNotFoundException($name);
            }

            $alternatives = array();
            foreach ($this->parameters as $key => $parameterValue) {
                $lev = levenshtein($name, $key);
                if ($lev <= strlen($name) / 3 || false !== strpos($key, $name)) {
                    $alternatives[] = $key;
                }
            }

<<<<<<< HEAD
            $nonNestedAlternative = null;
            if (!count($alternatives) && false !== strpos($name, '.')) {
                $namePartsLength = array_map('strlen', explode('.', $name));
                $key = substr($name, 0, -1 * (1 + array_pop($namePartsLength)));
                while (count($namePartsLength)) {
                    if ($this->has($key)) {
                        if (is_array($this->get($key))) {
                            $nonNestedAlternative = $key;
                        }
                        break;
                    }

                    $key = substr($key, 0, -1 * (1 + array_pop($namePartsLength)));
                }
            }

            throw new ParameterNotFoundException($name, null, null, null, $alternatives, $nonNestedAlternative);
=======
            throw new ParameterNotFoundException($name, null, null, null, $alternatives);
>>>>>>> web and vendor directory from composer install
        }

        return $this->parameters[$name];
    }

    /**
     * Sets a service container parameter.
     *
     * @param string $name  The parameter name
     * @param mixed  $value The parameter value
     */
    public function set($name, $value)
    {
<<<<<<< HEAD
        $this->parameters[$this->normalizeName($name)] = $value;
=======
        $this->parameters[strtolower($name)] = $value;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
<<<<<<< HEAD
        return array_key_exists($this->normalizeName($name), $this->parameters);
=======
        return array_key_exists(strtolower($name), $this->parameters);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Removes a parameter.
     *
     * @param string $name The parameter name
     */
    public function remove($name)
    {
<<<<<<< HEAD
        unset($this->parameters[$this->normalizeName($name)]);
=======
        unset($this->parameters[strtolower($name)]);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
    public function resolve()
    {
        if ($this->resolved) {
            return;
        }

        $parameters = array();
        foreach ($this->parameters as $key => $value) {
            try {
                $value = $this->resolveValue($value);
                $parameters[$key] = $this->unescapeValue($value);
            } catch (ParameterNotFoundException $e) {
                $e->setSourceKey($key);

                throw $e;
            }
        }

        $this->parameters = $parameters;
        $this->resolved = true;
    }

    /**
     * Replaces parameter placeholders (%name%) by their values.
     *
     * @param mixed $value     A value
     * @param array $resolving An array of keys that are being resolved (used internally to detect circular references)
     *
     * @return mixed The resolved value
     *
     * @throws ParameterNotFoundException          if a placeholder references a parameter that does not exist
     * @throws ParameterCircularReferenceException if a circular reference if detected
<<<<<<< HEAD
     * @throws RuntimeException                    when a given parameter has a type problem
     */
    public function resolveValue($value, array $resolving = array())
    {
        if (\is_array($value)) {
            $args = array();
            foreach ($value as $k => $v) {
                $args[\is_string($k) ? $this->resolveValue($k, $resolving) : $k] = $this->resolveValue($v, $resolving);
=======
     * @throws RuntimeException                    when a given parameter has a type problem.
     */
    public function resolveValue($value, array $resolving = array())
    {
        if (is_array($value)) {
            $args = array();
            foreach ($value as $k => $v) {
                $args[$this->resolveValue($k, $resolving)] = $this->resolveValue($v, $resolving);
>>>>>>> web and vendor directory from composer install
            }

            return $args;
        }

<<<<<<< HEAD
        if (!\is_string($value) || 2 > \strlen($value)) {
=======
        if (!is_string($value)) {
>>>>>>> web and vendor directory from composer install
            return $value;
        }

        return $this->resolveString($value, $resolving);
    }

    /**
     * Resolves parameters inside a string.
     *
     * @param string $value     The string to resolve
     * @param array  $resolving An array of keys that are being resolved (used internally to detect circular references)
     *
     * @return string The resolved string
     *
     * @throws ParameterNotFoundException          if a placeholder references a parameter that does not exist
     * @throws ParameterCircularReferenceException if a circular reference if detected
<<<<<<< HEAD
     * @throws RuntimeException                    when a given parameter has a type problem
=======
     * @throws RuntimeException                    when a given parameter has a type problem.
>>>>>>> web and vendor directory from composer install
     */
    public function resolveString($value, array $resolving = array())
    {
        // we do this to deal with non string values (Boolean, integer, ...)
        // as the preg_replace_callback throw an exception when trying
        // a non-string in a parameter value
        if (preg_match('/^%([^%\s]+)%$/', $value, $match)) {
<<<<<<< HEAD
            $key = $match[1];
            $lcKey = strtolower($key); // strtolower() to be removed in 4.0

            if (isset($resolving[$lcKey])) {
                throw new ParameterCircularReferenceException(array_keys($resolving));
            }

            $resolving[$lcKey] = true;
=======
            $key = strtolower($match[1]);

            if (isset($resolving[$key])) {
                throw new ParameterCircularReferenceException(array_keys($resolving));
            }

            $resolving[$key] = true;
>>>>>>> web and vendor directory from composer install

            return $this->resolved ? $this->get($key) : $this->resolveValue($this->get($key), $resolving);
        }

<<<<<<< HEAD
        return preg_replace_callback('/%%|%([^%\s]+)%/', function ($match) use ($resolving, $value) {
=======
        $self = $this;

        return preg_replace_callback('/%%|%([^%\s]+)%/', function ($match) use ($self, $resolving, $value) {
>>>>>>> web and vendor directory from composer install
            // skip %%
            if (!isset($match[1])) {
                return '%%';
            }

<<<<<<< HEAD
            $key = $match[1];
            $lcKey = strtolower($key); // strtolower() to be removed in 4.0
            if (isset($resolving[$lcKey])) {
                throw new ParameterCircularReferenceException(array_keys($resolving));
            }

            $resolved = $this->get($key);
=======
            $key = strtolower($match[1]);
            if (isset($resolving[$key])) {
                throw new ParameterCircularReferenceException(array_keys($resolving));
            }

            $resolved = $self->get($key);
>>>>>>> web and vendor directory from composer install

            if (!is_string($resolved) && !is_numeric($resolved)) {
                throw new RuntimeException(sprintf('A string value must be composed of strings and/or numbers, but found parameter "%s" of type %s inside string value "%s".', $key, gettype($resolved), $value));
            }

            $resolved = (string) $resolved;
<<<<<<< HEAD
            $resolving[$lcKey] = true;

            return $this->isResolved() ? $resolved : $this->resolveString($resolved, $resolving);
=======
            $resolving[$key] = true;

            return $self->isResolved() ? $resolved : $self->resolveString($resolved, $resolving);
>>>>>>> web and vendor directory from composer install
        }, $value);
    }

    public function isResolved()
    {
        return $this->resolved;
    }

    /**
     * {@inheritdoc}
     */
    public function escapeValue($value)
    {
        if (is_string($value)) {
            return str_replace('%', '%%', $value);
        }

        if (is_array($value)) {
            $result = array();
            foreach ($value as $k => $v) {
                $result[$k] = $this->escapeValue($v);
            }

            return $result;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function unescapeValue($value)
    {
        if (is_string($value)) {
            return str_replace('%%', '%', $value);
        }

        if (is_array($value)) {
            $result = array();
            foreach ($value as $k => $v) {
                $result[$k] = $this->unescapeValue($v);
            }

            return $result;
        }

        return $value;
    }
<<<<<<< HEAD

    private function normalizeName($name)
    {
        if (isset($this->normalizedNames[$normalizedName = strtolower($name)])) {
            $normalizedName = $this->normalizedNames[$normalizedName];
            if ((string) $name !== $normalizedName) {
                @trigger_error(sprintf('Parameter names will be made case sensitive in Symfony 4.0. Using "%s" instead of "%s" is deprecated since Symfony 3.4.', $name, $normalizedName), E_USER_DEPRECATED);
            }
        } else {
            $normalizedName = $this->normalizedNames[$normalizedName] = (string) $name;
        }

        return $normalizedName;
    }
=======
>>>>>>> web and vendor directory from composer install
}
