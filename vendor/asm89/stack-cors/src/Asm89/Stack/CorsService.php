<?php

<<<<<<< HEAD
/*
 * This file is part of asm89/stack-cors.
 *
 * (c) Alexander <iam.asm89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

=======
>>>>>>> web and vendor directory from composer install
namespace Asm89\Stack;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsService
{
    private $options;

    public function __construct(array $options = array())
    {
        $this->options = $this->normalizeOptions($options);
    }

    private function normalizeOptions(array $options = array())
    {
<<<<<<< HEAD
        $options += array(
            'allowedOrigins' => array(),
            'allowedOriginsPatterns' => array(),
=======

        $options += array(
            'allowedOrigins' => array(),
>>>>>>> web and vendor directory from composer install
            'supportsCredentials' => false,
            'allowedHeaders' => array(),
            'exposedHeaders' => array(),
            'allowedMethods' => array(),
            'maxAge' => 0,
        );

        // normalize array('*') to true
        if (in_array('*', $options['allowedOrigins'])) {
<<<<<<< HEAD
            $options['allowedOrigins'] = true;
        }
        if (in_array('*', $options['allowedHeaders'])) {
            $options['allowedHeaders'] = true;
        } else {
            $options['allowedHeaders'] = array_map('strtolower', $options['allowedHeaders']);
        }

        if (in_array('*', $options['allowedMethods'])) {
            $options['allowedMethods'] = true;
        } else {
            $options['allowedMethods'] = array_map('strtoupper', $options['allowedMethods']);
=======
          $options['allowedOrigins'] = true;
        }
        if (in_array('*', $options['allowedHeaders'])) {
          $options['allowedHeaders'] = true;
        } else {
          $options['allowedHeaders'] = array_map('strtolower', $options['allowedHeaders']);
        }

        if (in_array('*', $options['allowedMethods'])) {
          $options['allowedMethods'] = true;
        } else {
          $options['allowedMethods'] = array_map('strtoupper', $options['allowedMethods']);
>>>>>>> web and vendor directory from composer install
        }

        return $options;
    }

    public function isActualRequestAllowed(Request $request)
    {
        return $this->checkOrigin($request);
    }

    public function isCorsRequest(Request $request)
    {
<<<<<<< HEAD
        return $request->headers->has('Origin') && !$this->isSameHost($request);
=======
        return $request->headers->has('Origin');
>>>>>>> web and vendor directory from composer install
    }

    public function isPreflightRequest(Request $request)
    {
        return $this->isCorsRequest($request)
<<<<<<< HEAD
            && $request->getMethod() === 'OPTIONS'
=======
            &&$request->getMethod() === 'OPTIONS'
>>>>>>> web and vendor directory from composer install
            && $request->headers->has('Access-Control-Request-Method');
    }

    public function addActualRequestHeaders(Response $response, Request $request)
    {
<<<<<<< HEAD
        if (!$this->checkOrigin($request)) {
=======
        if ( ! $this->checkOrigin($request)) {
>>>>>>> web and vendor directory from composer install
            return $response;
        }

        $response->headers->set('Access-Control-Allow-Origin', $request->headers->get('Origin'));

<<<<<<< HEAD
        if (!$response->headers->has('Vary')) {
=======
        if ( ! $response->headers->has('Vary')) {
>>>>>>> web and vendor directory from composer install
            $response->headers->set('Vary', 'Origin');
        } else {
            $response->headers->set('Vary', $response->headers->get('Vary') . ', Origin');
        }

        if ($this->options['supportsCredentials']) {
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
        }

        if ($this->options['exposedHeaders']) {
            $response->headers->set('Access-Control-Expose-Headers', implode(', ', $this->options['exposedHeaders']));
        }

        return $response;
    }

    public function handlePreflightRequest(Request $request)
    {
        if (true !== $check = $this->checkPreflightRequestConditions($request)) {
            return $check;
        }

        return $this->buildPreflightCheckResponse($request);
    }

    private function buildPreflightCheckResponse(Request $request)
    {
        $response = new Response();

        if ($this->options['supportsCredentials']) {
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
        }

        $response->headers->set('Access-Control-Allow-Origin', $request->headers->get('Origin'));

        if ($this->options['maxAge']) {
            $response->headers->set('Access-Control-Max-Age', $this->options['maxAge']);
        }

        $allowMethods = $this->options['allowedMethods'] === true
            ? strtoupper($request->headers->get('Access-Control-Request-Method'))
            : implode(', ', $this->options['allowedMethods']);
        $response->headers->set('Access-Control-Allow-Methods', $allowMethods);

        $allowHeaders = $this->options['allowedHeaders'] === true
            ? strtoupper($request->headers->get('Access-Control-Request-Headers'))
            : implode(', ', $this->options['allowedHeaders']);
        $response->headers->set('Access-Control-Allow-Headers', $allowHeaders);

        return $response;
    }

    private function checkPreflightRequestConditions(Request $request)
    {
<<<<<<< HEAD
        if (!$this->checkOrigin($request)) {
            return $this->createBadRequestResponse(403, 'Origin not allowed');
        }

        if (!$this->checkMethod($request)) {
=======
        if ( ! $this->checkOrigin($request)) {
            return $this->createBadRequestResponse(403, 'Origin not allowed');
        }

        if ( ! $this->checkMethod($request)) {
>>>>>>> web and vendor directory from composer install
            return $this->createBadRequestResponse(405, 'Method not allowed');
        }

        $requestHeaders = array();
        // if allowedHeaders has been set to true ('*' allow all flag) just skip this check
        if ($this->options['allowedHeaders'] !== true && $request->headers->has('Access-Control-Request-Headers')) {
            $headers        = strtolower($request->headers->get('Access-Control-Request-Headers'));
<<<<<<< HEAD
            $requestHeaders = array_filter(explode(',', $headers));

            foreach ($requestHeaders as $header) {
                if (!in_array(trim($header), $this->options['allowedHeaders'])) {
=======
            $requestHeaders = explode(',', $headers);

            foreach ($requestHeaders as $header) {
                if ( ! in_array(trim($header), $this->options['allowedHeaders'])) {
>>>>>>> web and vendor directory from composer install
                    return $this->createBadRequestResponse(403, 'Header not allowed');
                }
            }
        }

        return true;
    }

    private function createBadRequestResponse($code, $reason = '')
    {
        return new Response($reason, $code);
    }

<<<<<<< HEAD
    private function isSameHost(Request $request)
    {
        return $request->headers->get('Origin') === $request->getSchemeAndHttpHost();
    }

    private function checkOrigin(Request $request)
    {
=======
    private function checkOrigin(Request $request) {
>>>>>>> web and vendor directory from composer install
        if ($this->options['allowedOrigins'] === true) {
            // allow all '*' flag
            return true;
        }
        $origin = $request->headers->get('Origin');

<<<<<<< HEAD
        if (in_array($origin, $this->options['allowedOrigins'])) {
            return true;
        }

        foreach ($this->options['allowedOriginsPatterns'] as $pattern) {
            if (preg_match($pattern, $origin)) {
                return true;
            }
        }

        return false;
    }

    private function checkMethod(Request $request)
    {
=======
        return in_array($origin, $this->options['allowedOrigins']);
    }

    private function checkMethod(Request $request) {
>>>>>>> web and vendor directory from composer install
        if ($this->options['allowedMethods'] === true) {
            // allow all '*' flag
            return true;
        }

        $requestMethod = strtoupper($request->headers->get('Access-Control-Request-Method'));
        return in_array($requestMethod, $this->options['allowedMethods']);
    }
<<<<<<< HEAD
=======

>>>>>>> web and vendor directory from composer install
}
