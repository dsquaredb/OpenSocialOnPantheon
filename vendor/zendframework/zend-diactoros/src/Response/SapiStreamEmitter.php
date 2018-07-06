<?php
/**
<<<<<<< HEAD
 * Zend Framework (http://framework.zend.com/)
 *
 * @see       http://github.com/zendframework/zend-diactoros for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Zend Technologies USA Inc. (http://www.zend.com)
=======
 * @see       https://github.com/zendframework/zend-diactoros for the canonical source repository
<<<<<<< HEAD
 * @copyright Copyright (c) 2015-2018 Zend Technologies USA Inc. (http://www.zend.com)
>>>>>>> Update Open Social to 8.x-2.1
=======
 * @copyright Copyright (c) 2015-2017 Zend Technologies USA Inc. (http://www.zend.com)
>>>>>>> revert Open Social update
 * @license   https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md New BSD License
 */

namespace Zend\Diactoros\Response;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Zend\Diactoros\RelativeStream;

class SapiStreamEmitter implements EmitterInterface
{
    use SapiEmitterTrait;

    /**
     * Emits a response for a PHP SAPI environment.
     *
     * Emits the status line and headers via the header() function, and the
     * body content via the output buffer.
     *
     * @param ResponseInterface $response
     * @param int $maxBufferLength Maximum output buffering size for each iteration
     */
    public function emit(ResponseInterface $response, $maxBufferLength = 8192)
    {
        if (headers_sent()) {
            throw new RuntimeException('Unable to emit response; headers already sent');
        }

        $response = $this->injectContentLength($response);

        $this->emitStatusLine($response);
        $this->emitHeaders($response);
        $this->flush();

        $range = $this->parseContentRange($response->getHeaderLine('Content-Range'));

<<<<<<< HEAD
        if (is_array($range) && $range[0] === 'bytes') {
=======
        if (is_array($range)) {
>>>>>>> web and vendor directory from composer install
            $this->emitBodyRange($range, $response, $maxBufferLength);
            return;
        }

        $this->emitBody($response, $maxBufferLength);
    }

    /**
     * Emit the message body.
     *
     * @param ResponseInterface $response
     * @param int $maxBufferLength
     */
    private function emitBody(ResponseInterface $response, $maxBufferLength)
    {
        $body = $response->getBody();

<<<<<<< HEAD
        if ($body->isSeekable()) {
            $body->rewind();
        }

        if (! $body->isReadable()) {
=======
        if (! $body->isSeekable()) {
>>>>>>> web and vendor directory from composer install
            echo $body;
            return;
        }

<<<<<<< HEAD
=======
        $body->rewind();
>>>>>>> web and vendor directory from composer install
        while (! $body->eof()) {
            echo $body->read($maxBufferLength);
        }
    }

    /**
     * Emit a range of the message body.
     *
     * @param array $range
     * @param ResponseInterface $response
     * @param int $maxBufferLength
     */
    private function emitBodyRange(array $range, ResponseInterface $response, $maxBufferLength)
    {
        list($unit, $first, $last, $length) = $range;

        $body = $response->getBody();

<<<<<<< HEAD
        $length = $last - $first + 1;

        if ($body->isSeekable()) {
            $body->seek($first);

            $first = 0;
        }

        if (! $body->isReadable()) {
            echo substr($body->getContents(), $first, $length);
            return;
        }

        $remaining = $length;

        while ($remaining >= $maxBufferLength && ! $body->eof()) {
            $contents   = $body->read($maxBufferLength);
            $remaining -= strlen($contents);

            echo $contents;
        }

        if ($remaining > 0 && ! $body->eof()) {
            echo $body->read($remaining);
=======
        if (! $body->isSeekable()) {
            $contents = $body->getContents();
            echo substr($contents, $first, $last - $first + 1);
            return;
        }

        $body = new RelativeStream($body, $first);
        $body->rewind();
        $pos = 0;
        $length = $last - $first + 1;
        while (! $body->eof() && $pos < $length) {
            if (($pos + $maxBufferLength) > $length) {
                echo $body->read($length - $pos);
                break;
            }

            echo $body->read($maxBufferLength);
            $pos = $body->tell();
>>>>>>> web and vendor directory from composer install
        }
    }

    /**
     * Parse content-range header
     * http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.16
     *
     * @param string $header
     * @return false|array [unit, first, last, length]; returns false if no
     *     content range or an invalid content range is provided
     */
    private function parseContentRange($header)
    {
        if (preg_match('/(?P<unit>[\w]+)\s+(?P<first>\d+)-(?P<last>\d+)\/(?P<length>\d+|\*)/', $header, $matches)) {
            return [
                $matches['unit'],
                (int) $matches['first'],
                (int) $matches['last'],
                $matches['length'] === '*' ? '*' : (int) $matches['length'],
            ];
        }
        return false;
    }
}
