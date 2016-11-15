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

<<<<<<< HEAD
use Symfony\Component\DependencyInjection\Argument\ArgumentInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Reference;
=======
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
>>>>>>> web and vendor directory from composer install

/**
 * Inline service definitions where this is possible.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
<<<<<<< HEAD
class InlineServiceDefinitionsPass extends AbstractRecursivePass implements RepeatablePassInterface
{
    private $cloningIds = array();
    private $inlinedServiceIds = array();
=======
class InlineServiceDefinitionsPass implements RepeatablePassInterface
{
    private $repeatedPass;
    private $graph;
    private $compiler;
    private $formatter;
    private $currentId;
>>>>>>> web and vendor directory from composer install

    /**
     * {@inheritdoc}
     */
    public function setRepeatedPass(RepeatedPass $repeatedPass)
    {
<<<<<<< HEAD
        // no-op for BC
    }

    /**
     * Returns an array of all services inlined by this pass.
     *
     * The key is the inlined service id and its value is the list of services it was inlined into.
     *
     * @deprecated since version 3.4, to be removed in 4.0.
     *
     * @return array
     */
    public function getInlinedServiceIds()
    {
        @trigger_error('Calling InlineServiceDefinitionsPass::getInlinedServiceIds() is deprecated since Symfony 3.4 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->inlinedServiceIds;
    }

    /**
     * {@inheritdoc}
     */
    protected function processValue($value, $isRoot = false)
    {
        if ($value instanceof ArgumentInterface) {
            // Reference found in ArgumentInterface::getValues() are not inlineable
            return $value;
        }

        if ($value instanceof Definition && $this->cloningIds) {
            if ($value->isShared()) {
                return $value;
            }
            $value = clone $value;
        }

        if (!$value instanceof Reference || !$this->container->hasDefinition($id = $this->container->normalizeId($value))) {
            return parent::processValue($value, $isRoot);
        }

        $definition = $this->container->getDefinition($id);

        if (!$this->isInlineableDefinition($id, $definition, $this->container->getCompiler()->getServiceReferenceGraph())) {
            return $value;
        }

        $this->container->log($this, sprintf('Inlined service "%s" to "%s".', $id, $this->currentId));
        $this->inlinedServiceIds[$id][] = $this->currentId;

        if ($definition->isShared()) {
            return $definition;
        }

        if (isset($this->cloningIds[$id])) {
            $ids = array_keys($this->cloningIds);
            $ids[] = $id;

            throw new ServiceCircularReferenceException($id, array_slice($ids, array_search($id, $ids)));
        }

        $this->cloningIds[$id] = true;
        try {
            return $this->processValue($definition);
        } finally {
            unset($this->cloningIds[$id]);
        }
=======
        $this->repeatedPass = $repeatedPass;
    }

    /**
     * Processes the ContainerBuilder for inline service definitions.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->compiler = $container->getCompiler();
        $this->formatter = $this->compiler->getLoggingFormatter();
        $this->graph = $this->compiler->getServiceReferenceGraph();

        $container->setDefinitions($this->inlineArguments($container, $container->getDefinitions(), true));
    }

    /**
     * Processes inline arguments.
     *
     * @param ContainerBuilder $container The ContainerBuilder
     * @param array            $arguments An array of arguments
     * @param bool             $isRoot    If we are processing the root definitions or not
     *
     * @return array
     */
    private function inlineArguments(ContainerBuilder $container, array $arguments, $isRoot = false)
    {
        foreach ($arguments as $k => $argument) {
            if ($isRoot) {
                $this->currentId = $k;
            }
            if (is_array($argument)) {
                $arguments[$k] = $this->inlineArguments($container, $argument);
            } elseif ($argument instanceof Reference) {
                if (!$container->hasDefinition($id = (string) $argument)) {
                    continue;
                }

                if ($this->isInlineableDefinition($container, $id, $definition = $container->getDefinition($id))) {
                    $this->compiler->addLogMessage($this->formatter->formatInlineService($this, $id, $this->currentId));

                    if ($definition->isShared() && ContainerInterface::SCOPE_PROTOTYPE !== $definition->getScope(false)) {
                        $arguments[$k] = $definition;
                    } else {
                        $arguments[$k] = clone $definition;
                    }
                }
            } elseif ($argument instanceof Definition) {
                $argument->setArguments($this->inlineArguments($container, $argument->getArguments()));
                $argument->setMethodCalls($this->inlineArguments($container, $argument->getMethodCalls()));
                $argument->setProperties($this->inlineArguments($container, $argument->getProperties()));

                $configurator = $this->inlineArguments($container, array($argument->getConfigurator()));
                $argument->setConfigurator($configurator[0]);

                $factory = $this->inlineArguments($container, array($argument->getFactory()));
                $argument->setFactory($factory[0]);
            }
        }

        return $arguments;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Checks if the definition is inlineable.
     *
<<<<<<< HEAD
     * @return bool If the definition is inlineable
     */
    private function isInlineableDefinition($id, Definition $definition, ServiceReferenceGraph $graph)
    {
        if (!$definition->isShared()) {
            return true;
        }

        if ($definition->isDeprecated() || $definition->isPublic() || $definition->isPrivate() || $definition->isLazy()) {
            return false;
        }

        if (!$graph->hasNode($id)) {
=======
     * @param ContainerBuilder $container
     * @param string           $id
     * @param Definition       $definition
     *
     * @return bool If the definition is inlineable
     */
    private function isInlineableDefinition(ContainerBuilder $container, $id, Definition $definition)
    {
        if (!$definition->isShared() || ContainerInterface::SCOPE_PROTOTYPE === $definition->getScope(false)) {
            return true;
        }

        if ($definition->isPublic() || $definition->isLazy()) {
            return false;
        }

        if (!$this->graph->hasNode($id)) {
>>>>>>> web and vendor directory from composer install
            return true;
        }

        if ($this->currentId == $id) {
            return false;
        }

        $ids = array();
<<<<<<< HEAD
        foreach ($graph->getNode($id)->getInEdges() as $edge) {
            if ($edge->isWeak()) {
                return false;
            }
=======
        foreach ($this->graph->getNode($id)->getInEdges() as $edge) {
>>>>>>> web and vendor directory from composer install
            $ids[] = $edge->getSourceNode()->getId();
        }

        if (count(array_unique($ids)) > 1) {
            return false;
        }

        if (count($ids) > 1 && is_array($factory = $definition->getFactory()) && ($factory[0] instanceof Reference || $factory[0] instanceof Definition)) {
            return false;
        }

<<<<<<< HEAD
        return !$ids || $this->container->getDefinition($ids[0])->isShared();
=======
        if (count($ids) > 1 && $definition->getFactoryService(false)) {
            return false;
        }

        return $container->getDefinition(reset($ids))->getScope(false) === $definition->getScope(false);
>>>>>>> web and vendor directory from composer install
    }
}
