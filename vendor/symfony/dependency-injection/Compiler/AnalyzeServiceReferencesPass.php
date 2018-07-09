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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ExpressionLanguage;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\ExpressionLanguage\Expression;
=======
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Run this pass before passes that need to know more about the relation of
 * your services.
 *
 * This class will populate the ServiceReferenceGraph with information. You can
 * retrieve the graph in other passes from the compiler.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
 
class AnalyzeServiceReferencesPass extends AbstractRecursivePass implements RepeatablePassInterface
{
    private $graph;
    private $currentDefinition;
    private $onlyConstructorArguments;
    private $lazy;
    private $expressionLanguage;
=======
class AnalyzeServiceReferencesPass implements RepeatablePassInterface
{
    private $graph;
    private $container;
    private $currentId;
    private $currentDefinition;
    private $repeatedPass;
    private $onlyConstructorArguments;

    /**
     * @param bool $onlyConstructorArguments Sets this Service Reference pass to ignore method calls
     */
    public function __construct($onlyConstructorArguments = false)
    {
        $this->onlyConstructorArguments = (bool) $onlyConstructorArguments;
    }

    /**
     * {@inheritdoc}
     */
    public function setRepeatedPass(RepeatedPass $repeatedPass)
    {
 
        // no-op for BC
=======
        $this->repeatedPass = $repeatedPass;
    }

    /**
     * Processes a ContainerBuilder object to populate the service reference graph.
 
=======
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->container = $container;
        $this->graph = $container->getCompiler()->getServiceReferenceGraph();
        $this->graph->clear();
 
        $this->lazy = false;

        foreach ($container->getAliases() as $id => $alias) {
            $targetId = $this->getDefinitionId((string) $alias);
            $this->graph->connect($id, $alias, $targetId, $this->getDefinition($targetId), null);
        }

        parent::process($container);
    }

    protected function processValue($value, $isRoot = false)
    {
        $lazy = $this->lazy;

        if ($value instanceof ArgumentInterface) {
            $this->lazy = true;
            parent::processValue($value->getValues());
            $this->lazy = $lazy;

            return $value;
        }
        if ($value instanceof Expression) {
            $this->getExpressionLanguage()->compile((string) $value, array('this' => 'container'));

            return $value;
        }
        if ($value instanceof Reference) {
            $targetId = $this->getDefinitionId((string) $value);
            $targetDefinition = $this->getDefinition($targetId);

            $this->graph->connect(
                $this->currentId,
                $this->currentDefinition,
                $targetId,
                $targetDefinition,
                $value,
                $this->lazy || ($targetDefinition && $targetDefinition->isLazy()),
                ContainerInterface::IGNORE_ON_UNINITIALIZED_REFERENCE === $value->getInvalidBehavior()
            );

            return $value;
        }
        if (!$value instanceof Definition) {
            return parent::processValue($value, $isRoot);
        }
        if ($isRoot) {
            if ($value->isSynthetic() || $value->isAbstract()) {
                return $value;
            }
            $this->currentDefinition = $value;
        }
        $this->lazy = false;

        $this->processValue($value->getFactory());
        $this->processValue($value->getArguments());

        if (!$this->onlyConstructorArguments) {
            $this->processValue($value->getProperties());
            $this->processValue($value->getMethodCalls());
            $this->processValue($value->getConfigurator());
        }
        $this->lazy = $lazy;

        return $value;
=======

        foreach ($container->getDefinitions() as $id => $definition) {
            if ($definition->isSynthetic() || $definition->isAbstract()) {
                continue;
            }

            $this->currentId = $id;
            $this->currentDefinition = $definition;

            $this->processArguments($definition->getArguments());
            if ($definition->getFactoryService(false)) {
                $this->processArguments(array(new Reference($definition->getFactoryService(false))));
            }
            if (is_array($definition->getFactory())) {
                $this->processArguments($definition->getFactory());
            }

            if (!$this->onlyConstructorArguments) {
                $this->processArguments($definition->getMethodCalls());
                $this->processArguments($definition->getProperties());
                if ($definition->getConfigurator()) {
                    $this->processArguments(array($definition->getConfigurator()));
                }
            }
        }

        foreach ($container->getAliases() as $id => $alias) {
            $this->graph->connect($id, $alias, (string) $alias, $this->getDefinition((string) $alias), null);
        }
    }

    /**
     * Processes service definitions for arguments to find relationships for the service graph.
     *
     * @param array $arguments An array of Reference or Definition objects relating to service definitions
     */
    private function processArguments(array $arguments)
    {
        foreach ($arguments as $argument) {
            if (is_array($argument)) {
                $this->processArguments($argument);
            } elseif ($argument instanceof Reference) {
                $this->graph->connect(
                    $this->currentId,
                    $this->currentDefinition,
                    $this->getDefinitionId((string) $argument),
                    $this->getDefinition((string) $argument),
                    $argument
                );
            } elseif ($argument instanceof Definition) {
                $this->processArguments($argument->getArguments());
                $this->processArguments($argument->getMethodCalls());
                $this->processArguments($argument->getProperties());

                if (is_array($argument->getFactory())) {
                    $this->processArguments($argument->getFactory());
                }
                if ($argument->getFactoryService(false)) {
                    $this->processArguments(array(new Reference($argument->getFactoryService(false))));
                }
            }
        }
    }

    /**
     * Returns a service definition given the full name or an alias.
     *
     * @param string $id A full id or alias for a service definition
     *
     * @return Definition|null The definition related to the supplied id
     */
    private function getDefinition($id)
    {
 
=======
        $id = $this->getDefinitionId($id);

        return null === $id ? null : $this->container->getDefinition($id);
    }

    private function getDefinitionId($id)
    {
        while ($this->container->hasAlias($id)) {
            $id = (string) $this->container->getAlias($id);
        }

        if (!$this->container->hasDefinition($id)) {
            return;
        }

 
        return $this->container->normalizeId($id);
    }

    private function getExpressionLanguage()
    {
        if (null === $this->expressionLanguage) {
            if (!class_exists(ExpressionLanguage::class)) {
                throw new RuntimeException('Unable to use expressions as the Symfony ExpressionLanguage component is not installed.');
            }

            $providers = $this->container->getExpressionLanguageProviders();
            $this->expressionLanguage = new ExpressionLanguage(null, $providers, function ($arg) {
                if ('""' === substr_replace($arg, '', 1, -1)) {
                    $id = stripcslashes(substr($arg, 1, -1));
                    $id = $this->getDefinitionId($id);

                    $this->graph->connect(
                        $this->currentId,
                        $this->currentDefinition,
                        $id,
                        $this->getDefinition($id)
                    );
                }

                return sprintf('$this->get(%s)', $arg);
            });
        }

        return $this->expressionLanguage;
=======
        return $id;
    }
}
