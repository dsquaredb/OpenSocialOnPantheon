<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel;

/**
 * Signs URIs.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class UriSigner
{
    private $secret;
<<<<<<< HEAD
    private $parameter;

    /**
     * @param string $secret    A secret
     * @param string $parameter Query string parameter to use
     */
    public function __construct($secret, $parameter = '_hash')
    {
        $this->secret = $secret;
        $this->parameter = $parameter;
=======

    /**
     * Constructor.
     *
     * @param string $secret A secret
     */
    public function __construct($secret)
    {
        $this->secret = $secret;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Signs a URI.
     *
<<<<<<< HEAD
     * The given URI is signed by adding the query string parameter
=======
     * The given URI is signed by adding a _hash query string parameter
>>>>>>> web and vendor directory from composer install
     * which value depends on the URI and the secret.
     *
     * @param string $uri A URI to sign
     *
     * @return string The signed URI
     */
    public function sign($uri)
    {
        $url = parse_url($uri);
        if (isset($url['query'])) {
            parse_str($url['query'], $params);
        } else {
            $params = array();
        }

        $uri = $this->buildUrl($url, $params);

<<<<<<< HEAD
        return $uri.(false === strpos($uri, '?') ? '?' : '&').$this->parameter.'='.$this->computeHash($uri);
=======
        return $uri.(false === strpos($uri, '?') ? '?' : '&').'_hash='.$this->computeHash($uri);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Checks that a URI contains the correct hash.
     *
<<<<<<< HEAD
=======
     * The _hash query string parameter must be the last one
     * (as it is generated that way by the sign() method, it should
     * never be a problem).
     *
>>>>>>> web and vendor directory from composer install
     * @param string $uri A signed URI
     *
     * @return bool True if the URI is signed correctly, false otherwise
     */
    public function check($uri)
    {
        $url = parse_url($uri);
        if (isset($url['query'])) {
            parse_str($url['query'], $params);
        } else {
            $params = array();
        }

<<<<<<< HEAD
        if (empty($params[$this->parameter])) {
            return false;
        }

        $hash = urlencode($params[$this->parameter]);
        unset($params[$this->parameter]);
=======
        if (empty($params['_hash'])) {
            return false;
        }

        $hash = urlencode($params['_hash']);
        unset($params['_hash']);
>>>>>>> web and vendor directory from composer install

        return $this->computeHash($this->buildUrl($url, $params)) === $hash;
    }

    private function computeHash($uri)
    {
        return urlencode(base64_encode(hash_hmac('sha256', $uri, $this->secret, true)));
    }

    private function buildUrl(array $url, array $params = array())
    {
        ksort($params, SORT_STRING);
        $url['query'] = http_build_query($params, '', '&');

        $scheme = isset($url['scheme']) ? $url['scheme'].'://' : '';
        $host = isset($url['host']) ? $url['host'] : '';
        $port = isset($url['port']) ? ':'.$url['port'] : '';
        $user = isset($url['user']) ? $url['user'] : '';
        $pass = isset($url['pass']) ? ':'.$url['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($url['path']) ? $url['path'] : '';
        $query = isset($url['query']) && $url['query'] ? '?'.$url['query'] : '';
        $fragment = isset($url['fragment']) ? '#'.$url['fragment'] : '';

        return $scheme.$user.$pass.$host.$port.$path.$query.$fragment;
    }
}
