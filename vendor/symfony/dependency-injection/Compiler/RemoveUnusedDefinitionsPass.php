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

/**
 * Removes unused service definitions from the container.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class RemoveUnusedDefinitionsPass implements RepeatablePassInterface
{
    private $repeatedPass;

    /**
     * {@inheritdoc}
     */
    public function setRepeatedPass(RepeatedPass $repeatedPass)
    {
        $this->repeatedPass = $repeatedPass;
    }

    /**
     * Processes the ContainerBuilder to remove unused definitions.
<<<<<<< HEAD
     */
    public function process(ContainerBuilder $container)
    {
        $graph = $container->getCompiler()->getServiceReferenceGraph();

        $hasChanged = false;
        foreach ($container->getDefinitions() as $id => $definition) {
            if ($definition->isPublic() || $definition->isPrivate()) {
=======
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $compiler = $container->getCompiler();
        $formatter = $compiler->getLoggingFormatter();
        $graph = $compiler->getServiceReferenceGraph();

        $hasChanged = false;
        foreach ($container->getDefinitions() as $id => $definition) {
            if ($definition->isPublic()) {
>>>>>>> web and vendor directory from composer install
                continue;
            }

            if ($graph->hasNode($id)) {
                $edges = $graph->getNode($id)->getInEdges();
                $referencingAliases = array();
                $sourceIds = array();
                foreach ($edges as $edge) {
<<<<<<< HEAD
                    if ($edge->isWeak()) {
                        continue;
                    }
=======
>>>>>>> web and vendor directory from composer install
                    $node = $edge->getSourceNode();
                    $sourceIds[] = $node->getId();

                    if ($node->isAlias()) {
                        $referencingAliases[] = $node->getValue();
                    }
                }
                $isReferenced = (count(array_unique($sourceIds)) - count($referencingAliases)) > 0;
            } else {
                $referencingAliases = array();
                $isReferenced = false;
            }

            if (1 === count($referencingAliases) && false === $isReferenced) {
                $container->setDefinition((string) reset($referencingAliases), $definition);
<<<<<<< HEAD
                $definition->setPublic(!$definition->isPrivate());
                $definition->setPrivate(reset($referencingAliases)->isPrivate());
                $container->removeDefinition($id);
                $container->log($this, sprintf('Removed service "%s"; reason: replaces alias %s.', $id, reset($referencingAliases)));
            } elseif (0 === count($referencingAliases) && false === $isReferenced) {
                $container->removeDefinition($id);
                $container->resolveEnvPlaceholders(serialize($definition));
                $container->log($this, sprintf('Removed service "%s"; reason: unused.', $id));
=======
                $definition->setPublic(true);
                $container->removeDefinition($id);
                $compiler->addLogMessage($formatter->formatRemoveService($this, $id, 'replaces alias '.reset($referencingAliases)));
            } elseif (0 === count($referencingAliases) && false === $isReferenced) {
                $container->removeDefinition($id);
                $compiler->addLogMessage($formatter->formatRemoveService($this, $id, 'unused'));
>>>>>>> web and vendor directory from composer install
                $hasChanged = true;
            }
        }

        if ($hasChanged) {
            $this->repeatedPass->setRepeat();
        }
    }
}
