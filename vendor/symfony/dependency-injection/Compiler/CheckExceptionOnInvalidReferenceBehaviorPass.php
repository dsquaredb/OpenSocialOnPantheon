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
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;
=======
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
>>>>>>> web and vendor directory from composer install

/**
 * Checks that all references are pointing to a valid service.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
<<<<<<< HEAD
class CheckExceptionOnInvalidReferenceBehaviorPass extends AbstractRecursivePass
{
    protected function processValue($value, $isRoot = false)
    {
        if (!$value instanceof Reference) {
            return parent::processValue($value, $isRoot);
        }
        if (ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE === $value->getInvalidBehavior() && !$this->container->has($id = (string) $value)) {
            throw new ServiceNotFoundException($id, $this->currentId);
        }

        return $value;
=======
class CheckExceptionOnInvalidReferenceBehaviorPass implements CompilerPassInterface
{
    private $container;
    private $sourceId;

    public function process(ContainerBuilder $container)
    {
        $this->container = $container;

        foreach ($container->getDefinitions() as $id => $definition) {
            $this->sourceId = $id;
            $this->processDefinition($definition);
        }
    }

    private function processDefinition(Definition $definition)
    {
        $this->processReferences($definition->getArguments());
        $this->processReferences($definition->getMethodCalls());
        $this->processReferences($definition->getProperties());
    }

    private function processReferences(array $arguments)
    {
        foreach ($arguments as $argument) {
            if (is_array($argument)) {
                $this->processReferences($argument);
            } elseif ($argument instanceof Definition) {
                $this->processDefinition($argument);
            } elseif ($argument instanceof Reference && ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE === $argument->getInvalidBehavior()) {
                $destId = (string) $argument;

                if (!$this->container->has($destId)) {
                    throw new ServiceNotFoundException($destId, $this->sourceId);
                }
            }
        }
>>>>>>> web and vendor directory from composer install
    }
}
