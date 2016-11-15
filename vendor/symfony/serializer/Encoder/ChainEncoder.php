<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer\Encoder;

use Symfony\Component\Serializer\Exception\RuntimeException;

/**
 * Encoder delegating the decoding to a chain of encoders.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 * @author Lukas Kahwe Smith <smith@pooteeweet.org>
<<<<<<< HEAD
 *
 * @final since version 3.3.
 */
class ChainEncoder implements EncoderInterface /*, ContextAwareEncoderInterface*/
=======
 */
class ChainEncoder implements EncoderInterface
>>>>>>> web and vendor directory from composer install
{
    protected $encoders = array();
    protected $encoderByFormat = array();

    public function __construct(array $encoders = array())
    {
        $this->encoders = $encoders;
    }

    /**
     * {@inheritdoc}
     */
    final public function encode($data, $format, array $context = array())
    {
<<<<<<< HEAD
        return $this->getEncoder($format, $context)->encode($data, $format, $context);
=======
        return $this->getEncoder($format)->encode($data, $format, $context);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function supportsEncoding($format/*, array $context = array()*/)
    {
        $context = func_num_args() > 1 ? func_get_arg(1) : array();

        try {
            $this->getEncoder($format, $context);
=======
    public function supportsEncoding($format)
    {
        try {
            $this->getEncoder($format);
>>>>>>> web and vendor directory from composer install
        } catch (RuntimeException $e) {
            return false;
        }

        return true;
    }

    /**
     * Checks whether the normalization is needed for the given format.
     *
     * @param string $format
<<<<<<< HEAD
     * @param array  $context
     *
     * @return bool
     */
    public function needsNormalization($format/*, array $context = array()*/)
    {
        $context = func_num_args() > 1 ? func_get_arg(1) : array();
        $encoder = $this->getEncoder($format, $context);
=======
     *
     * @return bool
     */
    public function needsNormalization($format)
    {
        $encoder = $this->getEncoder($format);
>>>>>>> web and vendor directory from composer install

        if (!$encoder instanceof NormalizationAwareInterface) {
            return true;
        }

        if ($encoder instanceof self) {
<<<<<<< HEAD
            return $encoder->needsNormalization($format, $context);
=======
            return $encoder->needsNormalization($format);
>>>>>>> web and vendor directory from composer install
        }

        return false;
    }

    /**
     * Gets the encoder supporting the format.
     *
     * @param string $format
<<<<<<< HEAD
     * @param array  $context
=======
>>>>>>> web and vendor directory from composer install
     *
     * @return EncoderInterface
     *
     * @throws RuntimeException if no encoder is found
     */
<<<<<<< HEAD
    private function getEncoder($format, array $context)
=======
    private function getEncoder($format)
>>>>>>> web and vendor directory from composer install
    {
        if (isset($this->encoderByFormat[$format])
            && isset($this->encoders[$this->encoderByFormat[$format]])
        ) {
            return $this->encoders[$this->encoderByFormat[$format]];
        }

        foreach ($this->encoders as $i => $encoder) {
<<<<<<< HEAD
            if ($encoder->supportsEncoding($format, $context)) {
=======
            if ($encoder->supportsEncoding($format)) {
>>>>>>> web and vendor directory from composer install
                $this->encoderByFormat[$format] = $i;

                return $encoder;
            }
        }

        throw new RuntimeException(sprintf('No encoder found for format "%s".', $format));
    }
}
