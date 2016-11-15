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

use Symfony\Component\DependencyInjection\ContainerBuilder;
<<<<<<< HEAD
use Symfony\Component\DependencyInjection\Definition;
=======
>>>>>>> web and vendor directory from composer install
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Resolves all parameter placeholders "%somevalue%" to their real values.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
<<<<<<< HEAD
class ResolveParameterPlaceHoldersPass extends AbstractRecursivePass
{
    private $bag;
    private $resolveArrays;

    public function __construct($resolveArrays = true)
    {
        $this->resolveArrays = $resolveArrays;
    }

    /**
     * {@inheritdoc}
=======
class ResolveParameterPlaceHoldersPass implements CompilerPassInterface
{
    /**
     * Processes the ContainerBuilder to resolve parameter placeholders.
     *
     * @param ContainerBuilder $container
>>>>>>> web and vendor directory from composer install
     *
     * @throws ParameterNotFoundException
     */
    public function process(ContainerBuilder $container)
    {
<<<<<<< HEAD
        $this->bag = $container->getParameterBag();

        try {
            parent::process($container);

            $aliases = array();
            foreach ($container->getAliases() as $name => $target) {
                $this->currentId = $name;
                $aliases[$this->bag->resolveValue($name)] = $target;
            }
            $container->setAliases($aliases);
        } catch (ParameterNotFoundException $e) {
            $e->setSourceId($this->currentId);

            throw $e;
        }

        $this->bag->resolve();
        $this->bag = null;
    }

    protected function processValue($value, $isRoot = false)
    {
        if (is_string($value)) {
            $v = $this->bag->resolveValue($value);

            return $this->resolveArrays || !$v || !is_array($v) ? $v : $value;
        }
        if ($value instanceof Definition) {
            $value->setBindings($this->processValue($value->getBindings()));
            $changes = $value->getChanges();
            if (isset($changes['class'])) {
                $value->setClass($this->bag->resolveValue($value->getClass()));
            }
            if (isset($changes['file'])) {
                $value->setFile($this->bag->resolveValue($value->getFile()));
            }
        }

        $value = parent::processValue($value, $isRoot);

        if ($value && is_array($value)) {
            $value = array_combine($this->bag->resolveValue(array_keys($value)), $value);
        }

        return $value;
=======
        $parameterBag = $container->getParameterBag();

        foreach ($container->getDefinitions() as $id => $definition) {
            try {
                $definition->setClass($parameterBag->resolveValue($definition->getClass()));
                $definition->setFile($parameterBag->resolveValue($definition->getFile()));
                $definition->setArguments($parameterBag->resolveValue($definition->getArguments()));
                if ($definition->getFactoryClass(false)) {
                    $definition->setFactoryClass($parameterBag->resolveValue($definition->getFactoryClass(false)));
                }

                $factory = $definition->getFactory();

                if (is_array($factory) && isset($factory[0])) {
                    $factory[0] = $parameterBag->resolveValue($factory[0]);
                    $definition->setFactory($factory);
                }

                $calls = array();
                foreach ($definition->getMethodCalls() as $name => $arguments) {
                    $calls[$parameterBag->resolveValue($name)] = $parameterBag->resolveValue($arguments);
                }
                $definition->setMethodCalls($calls);

                $definition->setProperties($parameterBag->resolveValue($definition->getProperties()));
            } catch (ParameterNotFoundException $e) {
                $e->setSourceId($id);

                throw $e;
            }
        }

        $aliases = array();
        foreach ($container->getAliases() as $name => $target) {
            $aliases[$parameterBag->resolveValue($name)] = $parameterBag->resolveValue($target);
        }
        $container->setAliases($aliases);

        $parameterBag->resolve();
>>>>>>> web and vendor directory from composer install
    }
}
