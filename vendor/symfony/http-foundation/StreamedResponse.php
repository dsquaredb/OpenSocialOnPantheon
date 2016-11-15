<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

/**
 * StreamedResponse represents a streamed HTTP response.
 *
 * A StreamedResponse uses a callback for its content.
 *
 * The callback should use the standard PHP functions like echo
 * to stream the response back to the client. The flush() method
 * can also be used if needed.
 *
 * @see flush()
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class StreamedResponse extends Response
{
    protected $callback;
    protected $streamed;
    private $headersSent;

    /**
<<<<<<< HEAD
=======
     * Constructor.
     *
>>>>>>> web and vendor directory from composer install
     * @param callable|null $callback A valid PHP callback or null to set it later
     * @param int           $status   The response status code
     * @param array         $headers  An array of response headers
     */
<<<<<<< HEAD
    public function __construct(callable $callback = null, $status = 200, $headers = array())
=======
    public function __construct($callback = null, $status = 200, $headers = array())
>>>>>>> web and vendor directory from composer install
    {
        parent::__construct(null, $status, $headers);

        if (null !== $callback) {
            $this->setCallback($callback);
        }
        $this->streamed = false;
        $this->headersSent = false;
    }

    /**
     * Factory method for chainability.
     *
     * @param callable|null $callback A valid PHP callback or null to set it later
     * @param int           $status   The response status code
     * @param array         $headers  An array of response headers
     *
<<<<<<< HEAD
     * @return static
=======
     * @return StreamedResponse
>>>>>>> web and vendor directory from composer install
     */
    public static function create($callback = null, $status = 200, $headers = array())
    {
        return new static($callback, $status, $headers);
    }

    /**
     * Sets the PHP callback associated with this Response.
     *
     * @param callable $callback A valid PHP callback
     *
<<<<<<< HEAD
     * @return $this
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
=======
     * @throws \LogicException
     */
    public function setCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new \LogicException('The Response callback must be a valid PHP callable.');
        }
        $this->callback = $callback;
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     *
     * This method only sends the headers once.
<<<<<<< HEAD
     *
     * @return $this
=======
>>>>>>> web and vendor directory from composer install
     */
    public function sendHeaders()
    {
        if ($this->headersSent) {
<<<<<<< HEAD
            return $this;
=======
            return;
>>>>>>> web and vendor directory from composer install
        }

        $this->headersSent = true;

<<<<<<< HEAD
        return parent::sendHeaders();
=======
        parent::sendHeaders();
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     *
     * This method only sends the content once.
<<<<<<< HEAD
     *
     * @return $this
=======
>>>>>>> web and vendor directory from composer install
     */
    public function sendContent()
    {
        if ($this->streamed) {
<<<<<<< HEAD
            return $this;
=======
            return;
>>>>>>> web and vendor directory from composer install
        }

        $this->streamed = true;

        if (null === $this->callback) {
            throw new \LogicException('The Response callback must not be null.');
        }

        call_user_func($this->callback);
<<<<<<< HEAD

        return $this;
=======
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException when the content is not null
<<<<<<< HEAD
     *
     * @return $this
=======
>>>>>>> web and vendor directory from composer install
     */
    public function setContent($content)
    {
        if (null !== $content) {
            throw new \LogicException('The content cannot be set on a StreamedResponse instance.');
        }
<<<<<<< HEAD

        return $this;
=======
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     *
     * @return false
     */
    public function getContent()
    {
        return false;
    }
}
