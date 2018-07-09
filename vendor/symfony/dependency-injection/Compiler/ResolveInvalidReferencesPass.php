<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Compiler;

 
use Symfony\Component\DependencyInjection\Argument\ArgumentInterface;
use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
=======
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * Emulates the invalid behavior if the reference is not found within the
 * container.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class ResolveInvalidReferencesPass implements CompilerPassInterface
{
    private $container;
 
    private $signalingException;

    /**
     * Process the ContainerBuilder to resolve invalid references.
=======

    /**
     * Process the ContainerBuilder to resolve invalid references.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->container = $container;
 
        $this->signalingException = new RuntimeException('Invalid reference.');

        try {
            $this->processValue($container->getDefinitions(), 1);
        } finally {
            $this->container = $this->signalingException = null;
=======
        foreach ($container->getDefinitions() as $definition) {
            if ($definition->isSynthetic() || $definition->isAbstract()) {
                continue;
            }

            $definition->setArguments(
                $this->processArguments($definition->getArguments())
            );

            $calls = array();
            foreach ($definition->getMethodCalls() as $call) {
                try {
                    $calls[] = array($call[0], $this->processArguments($call[1], true));
                } catch (RuntimeException $e) {
                    // this call is simply removed
                }
            }
            $definition->setMethodCalls($calls);

            $properties = array();
            foreach ($definition->getProperties() as $name => $value) {
                try {
                    $value = $this->processArguments(array($value), true);
                    $properties[$name] = reset($value);
                } catch (RuntimeException $e) {
                    // ignore property
                }
            }
            $definition->setProperties($properties);
        }
    }

    /**
     * Processes arguments to determine invalid references.
     *
 
     * @throws RuntimeException When an invalid reference is found
     */
    private function processValue($value, $rootLevel = 0, $level = 0)
    {
        if ($value instanceof ServiceClosureArgument) {
            $value->setValues($this->processValue($value->getValues(), 1, 1));
        } elseif ($value instanceof ArgumentInterface) {
            $value->setValues($this->processValue($value->getValues(), $rootLevel, 1 + $level));
        } elseif ($value instanceof Definition) {
            if ($value->isSynthetic() || $value->isAbstract()) {
                return $value;
            }
            $value->setArguments($this->processValue($value->getArguments(), 0));
            $value->setProperties($this->processValue($value->getProperties(), 1));
            $value->setMethodCalls($this->processValue($value->getMethodCalls(), 2));
        } elseif (is_array($value)) {
            $i = 0;

            foreach ($value as $k => $v) {
                try {
                    if (false !== $i && $k !== $i++) {
                        $i = false;
                    }
                    if ($v !== $processedValue = $this->processValue($v, $rootLevel, 1 + $level)) {
                        $value[$k] = $processedValue;
                    }
                } catch (RuntimeException $e) {
                    if ($rootLevel < $level || ($rootLevel && !$level)) {
                        unset($value[$k]);
                    } elseif ($rootLevel) {
                        throw $e;
                    } else {
                        $value[$k] = null;
                    }
                }
            }

            // Ensure numerically indexed arguments have sequential numeric keys.
            if (false !== $i) {
                $value = array_values($value);
            }
        } elseif ($value instanceof Reference) {
            if ($this->container->has($value)) {
                return $value;
            }
            $invalidBehavior = $value->getInvalidBehavior();

            // resolve invalid behavior
            if (ContainerInterface::NULL_ON_INVALID_REFERENCE === $invalidBehavior) {
                $value = null;
            } elseif (ContainerInterface::IGNORE_ON_INVALID_REFERENCE === $invalidBehavior) {
                if (0 < $level || $rootLevel) {
                    throw $this->signalingException;
                }
                $value = null;
            }
        }

        return $value;
=======
     * @param array $arguments    An array of Reference objects
     * @param bool  $inMethodCall
     *
     * @return array
     *
     * @throws RuntimeException When the config is invalid
     */
    private function processArguments(array $arguments, $inMethodCall = false)
    {
        foreach ($arguments as $k => $argument) {
            if (is_array($argument)) {
                $arguments[$k] = $this->processArguments($argument, $inMethodCall);
            } elseif ($argument instanceof Reference) {
                $id = (string) $argument;

                $invalidBehavior = $argument->getInvalidBehavior();
                $exists = $this->container->has($id);

                // resolve invalid behavior
                if (!$exists && ContainerInterface::NULL_ON_INVALID_REFERENCE === $invalidBehavior) {
                    $arguments[$k] = null;
                } elseif (!$exists && ContainerInterface::IGNORE_ON_INVALID_REFERENCE === $invalidBehavior) {
                    if ($inMethodCall) {
                        throw new RuntimeException('Method shouldn\'t be called.');
                    }

                    $arguments[$k] = null;
                }
            }
        }

        return $arguments;
    }
}
