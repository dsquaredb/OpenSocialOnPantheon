<?php
/**
<<<<<<< HEAD
 * Zend Framework (http://framework.zend.com/)
 *
 * @see       http://github.com/zendframework/zend-diactoros for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Zend Technologies USA Inc. (http://www.zend.com)
=======
 * @see       https://github.com/zendframework/zend-diactoros for the canonical source repository
 * @copyright Copyright (c) 2015-2018 Zend Technologies USA Inc. (http://www.zend.com)
>>>>>>> Update Open Social to 8.x-2.1
 * @license   https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md New BSD License
 */

namespace Zend\Diactoros\Response;

use Psr\Http\Message\ResponseInterface;

use function ob_get_length;
use function ob_get_level;
use function sprintf;
use function str_replace;
use function ucwords;

/**
 * @deprecated since 1.8.0. The package zendframework/zend-httphandlerrunner
 *     now provides this functionality.
 */
trait SapiEmitterTrait
{
    /**
     * Inject the Content-Length header if is not already present.
     *
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    private function injectContentLength(ResponseInterface $response)
    {
        if (! $response->hasHeader('Content-Length')) {
            // PSR-7 indicates int OR null for the stream size; for null values,
            // we will not auto-inject the Content-Length.
            if (null !== $response->getBody()->getSize()) {
                return $response->withHeader('Content-Length', (string) $response->getBody()->getSize());
            }
        }

        return $response;
    }

    /**
     * Emit the status line.
     *
     * Emits the status line using the protocol version and status code from
     * the response; if a reason phrase is available, it, too, is emitted.
     *
     * @param ResponseInterface $response
     */
    private function emitStatusLine(ResponseInterface $response)
    {
        $reasonPhrase = $response->getReasonPhrase();
        header(sprintf(
            'HTTP/%s %d%s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            ($reasonPhrase ? ' ' . $reasonPhrase : '')
        ));
    }

    /**
     * Emit response headers.
     *
     * Loops through each header, emitting each; if the header value
     * is an array with multiple values, ensures that each is sent
     * in such a way as to create aggregate headers (instead of replace
     * the previous).
     *
     * @param ResponseInterface $response
     */
    private function emitHeaders(ResponseInterface $response)
    {
        foreach ($response->getHeaders() as $header => $values) {
            $name  = $this->filterHeader($header);
<<<<<<< HEAD
            $first = $name === 'Set-Cookie' ? false : true;
=======
            $first = true;
>>>>>>> web and vendor directory from composer install
            foreach ($values as $value) {
                header(sprintf(
                    '%s: %s',
                    $name,
                    $value
                ), $first);
                $first = false;
            }
        }
    }

    /**
     * Loops through the output buffer, flushing each, before emitting
     * the response.
     *
     * @param int|null $maxBufferLevel Flush up to this buffer level.
     */
    private function flush($maxBufferLevel = null)
    {
        if (null === $maxBufferLevel) {
            $maxBufferLevel = ob_get_level();
        }

        while (ob_get_level() > $maxBufferLevel) {
            ob_end_flush();
        }
    }

    /**
     * Filter a header name to wordcase
     *
     * @param string $header
     * @return string
     */
    private function filterHeader($header)
    {
        $filtered = str_replace('-', ' ', $header);
        $filtered = ucwords($filtered);
        return str_replace(' ', '-', $filtered);
    }
}
