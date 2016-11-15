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

<<<<<<< HEAD
use Psr\Container\ContainerInterface;
=======
use Symfony\Component\DependencyInjection\ContainerInterface;
>>>>>>> web and vendor directory from composer install
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;

/**
 * Lazily loads fragment renderers from the dependency injection container.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class LazyLoadingFragmentHandler extends FragmentHandler
{
    private $container;
<<<<<<< HEAD
    /**
     * @deprecated since version 3.3, to be removed in 4.0
     */
    private $rendererIds = array();
    private $initialized = array();

    /**
=======
    private $rendererIds = array();

    /**
     * Constructor.
     *
     * RequestStack will become required in 3.0.
     *
>>>>>>> web and vendor directory from composer install
     * @param ContainerInterface $container    A container
     * @param RequestStack       $requestStack The Request stack that controls the lifecycle of requests
     * @param bool               $debug        Whether the debug mode is enabled or not
     */
<<<<<<< HEAD
    public function __construct(ContainerInterface $container, RequestStack $requestStack, $debug = false)
    {
        $this->container = $container;

=======
    public function __construct(ContainerInterface $container, $requestStack = null, $debug = false)
    {
        $this->container = $container;

        if ((null !== $requestStack && !$requestStack instanceof RequestStack) || $debug instanceof RequestStack) {
            $tmp = $debug;
            $debug = $requestStack;
            $requestStack = func_num_args() < 3 ? null : $tmp;

            @trigger_error('The '.__METHOD__.' method now requires a RequestStack to be given as second argument as '.__CLASS__.'::setRequest method will not be supported anymore in 3.0.', E_USER_DEPRECATED);
        } elseif (!$requestStack instanceof RequestStack) {
            @trigger_error('The '.__METHOD__.' method now requires a RequestStack instance as '.__CLASS__.'::setRequest method will not be supported anymore in 3.0.', E_USER_DEPRECATED);
        }

>>>>>>> web and vendor directory from composer install
        parent::__construct($requestStack, array(), $debug);
    }

    /**
     * Adds a service as a fragment renderer.
     *
     * @param string $name     The service name
     * @param string $renderer The render service id
<<<<<<< HEAD
     *
     * @deprecated since version 3.3, to be removed in 4.0
     */
    public function addRendererService($name, $renderer)
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.3 and will be removed in 4.0.', __METHOD__), E_USER_DEPRECATED);

=======
     */
    public function addRendererService($name, $renderer)
    {
>>>>>>> web and vendor directory from composer install
        $this->rendererIds[$name] = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function render($uri, $renderer = 'inline', array $options = array())
    {
<<<<<<< HEAD
        // BC 3.x, to be removed in 4.0
        if (isset($this->rendererIds[$renderer])) {
            $this->addRenderer($this->container->get($this->rendererIds[$renderer]));
            unset($this->rendererIds[$renderer]);

            return parent::render($uri, $renderer, $options);
        }

        if (!isset($this->initialized[$renderer]) && $this->container->has($renderer)) {
            $this->addRenderer($this->container->get($renderer));
            $this->initialized[$renderer] = true;
=======
        if (isset($this->rendererIds[$renderer])) {
            $this->addRenderer($this->container->get($this->rendererIds[$renderer]));

            unset($this->rendererIds[$renderer]);
>>>>>>> web and vendor directory from composer install
        }

        return parent::render($uri, $renderer, $options);
    }
}
