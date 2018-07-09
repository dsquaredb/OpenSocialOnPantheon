<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\DependencyInjection;

 
@trigger_error('The '.__NAMESPACE__.'\AddClassesToCachePass class is deprecated since Symfony 3.3 and will be removed in 4.0.', E_USER_DEPRECATED);
=======
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Sets the classes to compile in the cache for the container.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 
 *
 * @deprecated since version 3.3, to be removed in 4.0.
 */
class AddClassesToCachePass extends AddAnnotatedClassesToCachePass
{
=======
 */
class AddClassesToCachePass implements CompilerPassInterface
{
    private $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $classes = array();
        foreach ($container->getExtensions() as $extension) {
            if ($extension instanceof Extension) {
                $classes = array_merge($classes, $extension->getClassesToCompile());
            }
        }

        $this->kernel->setClassCache(array_unique($container->getParameterBag()->resolveValue($classes)));
    }
}
