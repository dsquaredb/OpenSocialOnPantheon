<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Matcher;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Route;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class RedirectableUrlMatcher extends UrlMatcher implements RedirectableUrlMatcherInterface
{
    /**
     * {@inheritdoc}
     */
    public function match($pathinfo)
    {
        try {
            $parameters = parent::match($pathinfo);
        } catch (ResourceNotFoundException $e) {
            if ('/' === substr($pathinfo, -1) || !in_array($this->context->getMethod(), array('HEAD', 'GET'))) {
                throw $e;
            }

            try {
<<<<<<< HEAD
                $parameters = parent::match($pathinfo.'/');

                return array_replace($parameters, $this->redirect($pathinfo.'/', isset($parameters['_route']) ? $parameters['_route'] : null));
=======
                parent::match($pathinfo.'/');

                return $this->redirect($pathinfo.'/', null);
>>>>>>> web and vendor directory from composer install
            } catch (ResourceNotFoundException $e2) {
                throw $e;
            }
        }

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    protected function handleRouteRequirements($pathinfo, $name, Route $route)
    {
        // expression condition
<<<<<<< HEAD
        if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), array('context' => $this->context, 'request' => $this->request ?: $this->createRequest($pathinfo)))) {
=======
        if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), array('context' => $this->context, 'request' => $this->request))) {
>>>>>>> web and vendor directory from composer install
            return array(self::REQUIREMENT_MISMATCH, null);
        }

        // check HTTP scheme requirement
        $scheme = $this->context->getScheme();
        $schemes = $route->getSchemes();
        if ($schemes && !$route->hasScheme($scheme)) {
            return array(self::ROUTE_MATCH, $this->redirect($pathinfo, $name, current($schemes)));
        }

        return array(self::REQUIREMENT_MATCH, null);
    }
}
