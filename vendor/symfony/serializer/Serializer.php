<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer;

use Symfony\Component\Serializer\Encoder\ChainDecoder;
use Symfony\Component\Serializer\Encoder\ChainEncoder;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
<<<<<<< HEAD
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Exception\LogicException;
=======
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
>>>>>>> web and vendor directory from composer install

/**
 * Serializer serializes and deserializes data.
 *
 * objects are turned into arrays by normalizers.
 * arrays are turned into various output formats by encoders.
 *
 * $serializer->serialize($obj, 'xml')
 * $serializer->decode($data, 'xml')
 * $serializer->denormalize($data, 'Class', 'xml')
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 * @author Lukas Kahwe Smith <smith@pooteeweet.org>
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class Serializer implements SerializerInterface, NormalizerInterface, DenormalizerInterface, EncoderInterface, DecoderInterface
{
    /**
     * @var Encoder\ChainEncoder
     */
    protected $encoder;

    /**
     * @var Encoder\ChainDecoder
     */
    protected $decoder;

    /**
     * @var array
     */
    protected $normalizers = array();

    /**
     * @var array
<<<<<<< HEAD
     *
     * @deprecated since 3.1 will be removed in 4.0
=======
>>>>>>> web and vendor directory from composer install
     */
    protected $normalizerCache = array();

    /**
     * @var array
<<<<<<< HEAD
     *
     * @deprecated since 3.1 will be removed in 4.0
=======
>>>>>>> web and vendor directory from composer install
     */
    protected $denormalizerCache = array();

    public function __construct(array $normalizers = array(), array $encoders = array())
    {
        foreach ($normalizers as $normalizer) {
            if ($normalizer instanceof SerializerAwareInterface) {
                $normalizer->setSerializer($this);
            }
<<<<<<< HEAD

            if ($normalizer instanceof DenormalizerAwareInterface) {
                $normalizer->setDenormalizer($this);
            }

            if ($normalizer instanceof NormalizerAwareInterface) {
                $normalizer->setNormalizer($this);
            }
=======
>>>>>>> web and vendor directory from composer install
        }
        $this->normalizers = $normalizers;

        $decoders = array();
        $realEncoders = array();
        foreach ($encoders as $encoder) {
            if ($encoder instanceof SerializerAwareInterface) {
                $encoder->setSerializer($this);
            }
            if ($encoder instanceof DecoderInterface) {
                $decoders[] = $encoder;
            }
            if ($encoder instanceof EncoderInterface) {
                $realEncoders[] = $encoder;
            }
        }
        $this->encoder = new ChainEncoder($realEncoders);
        $this->decoder = new ChainDecoder($decoders);
    }

    /**
     * {@inheritdoc}
     */
    final public function serialize($data, $format, array $context = array())
    {
<<<<<<< HEAD
        if (!$this->supportsEncoding($format, $context)) {
            throw new NotEncodableValueException(sprintf('Serialization for the format %s is not supported', $format));
        }

        if ($this->encoder->needsNormalization($format, $context)) {
=======
        if (!$this->supportsEncoding($format)) {
            throw new UnexpectedValueException(sprintf('Serialization for the format %s is not supported', $format));
        }

        if ($this->encoder->needsNormalization($format)) {
>>>>>>> web and vendor directory from composer install
            $data = $this->normalize($data, $format, $context);
        }

        return $this->encode($data, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    final public function deserialize($data, $type, $format, array $context = array())
    {
<<<<<<< HEAD
        if (!$this->supportsDecoding($format, $context)) {
            throw new NotEncodableValueException(sprintf('Deserialization for the format %s is not supported', $format));
=======
        if (!$this->supportsDecoding($format)) {
            throw new UnexpectedValueException(sprintf('Deserialization for the format %s is not supported', $format));
>>>>>>> web and vendor directory from composer install
        }

        $data = $this->decode($data, $format, $context);

        return $this->denormalize($data, $type, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($data, $format = null, array $context = array())
    {
        // If a normalizer supports the given data, use it
<<<<<<< HEAD
        if ($normalizer = $this->getNormalizer($data, $format, $context)) {
=======
        if ($normalizer = $this->getNormalizer($data, $format)) {
>>>>>>> web and vendor directory from composer install
            return $normalizer->normalize($data, $format, $context);
        }

        if (null === $data || is_scalar($data)) {
            return $data;
        }

<<<<<<< HEAD
        if (\is_array($data) || $data instanceof \Traversable) {
=======
        if (is_array($data) || $data instanceof \Traversable) {
>>>>>>> web and vendor directory from composer install
            $normalized = array();
            foreach ($data as $key => $val) {
                $normalized[$key] = $this->normalize($val, $format, $context);
            }

            return $normalized;
        }

<<<<<<< HEAD
        if (\is_object($data)) {
=======
        if (is_object($data)) {
>>>>>>> web and vendor directory from composer install
            if (!$this->normalizers) {
                throw new LogicException('You must register at least one normalizer to be able to normalize objects.');
            }

<<<<<<< HEAD
            throw new NotNormalizableValueException(sprintf('Could not normalize object of type %s, no supporting normalizer found.', \get_class($data)));
        }

        throw new NotNormalizableValueException(sprintf('An unexpected value could not be normalized: %s', var_export($data, true)));
=======
            throw new UnexpectedValueException(sprintf('Could not normalize object of type %s, no supporting normalizer found.', get_class($data)));
        }

        throw new UnexpectedValueException(sprintf('An unexpected value could not be normalized: %s', var_export($data, true)));
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
<<<<<<< HEAD
     *
     * @throws NotNormalizableValueException
     */
    public function denormalize($data, $type, $format = null, array $context = array())
    {
        if (!$this->normalizers) {
            throw new LogicException('You must register at least one normalizer to be able to denormalize objects.');
        }

        if ($normalizer = $this->getDenormalizer($data, $type, $format, $context)) {
            return $normalizer->denormalize($data, $type, $format, $context);
        }

        throw new NotNormalizableValueException(sprintf('Could not denormalize object of type %s, no supporting normalizer found.', $type));
=======
     */
    public function denormalize($data, $type, $format = null, array $context = array())
    {
        return $this->denormalizeObject($data, $type, $format, $context);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function supportsNormalization($data, $format = null/*, array $context = array()*/)
    {
        if (\func_num_args() > 2) {
            $context = \func_get_arg(2);
        } else {
            if (__CLASS__ !== \get_class($this)) {
                $r = new \ReflectionMethod($this, __FUNCTION__);
                if (__CLASS__ !== $r->getDeclaringClass()->getName()) {
                    @trigger_error(sprintf('Method %s() will have a third `$context = array()` argument in version 4.0. Not defining it is deprecated since Symfony 3.3.', __METHOD__), E_USER_DEPRECATED);
                }
            }

            $context = array();
        }

        return null !== $this->getNormalizer($data, $format, $context);
=======
    public function supportsNormalization($data, $format = null)
    {
        return null !== $this->getNormalizer($data, $format);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function supportsDenormalization($data, $type, $format = null/*, array $context = array()*/)
    {
        if (\func_num_args() > 3) {
            $context = \func_get_arg(3);
        } else {
            if (__CLASS__ !== \get_class($this)) {
                $r = new \ReflectionMethod($this, __FUNCTION__);
                if (__CLASS__ !== $r->getDeclaringClass()->getName()) {
                    @trigger_error(sprintf('Method %s() will have a fourth `$context = array()` argument in version 4.0. Not defining it is deprecated since Symfony 3.3.', __METHOD__), E_USER_DEPRECATED);
                }
            }

            $context = array();
        }

        return null !== $this->getDenormalizer($data, $type, $format, $context);
=======
    public function supportsDenormalization($data, $type, $format = null)
    {
        return null !== $this->getDenormalizer($data, $type, $format);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Returns a matching normalizer.
     *
<<<<<<< HEAD
     * @param mixed  $data    Data to get the serializer for
     * @param string $format  Format name, present to give the option to normalizers to act differently based on formats
     * @param array  $context Options available to the normalizer
     *
     * @return NormalizerInterface|null
     */
    private function getNormalizer($data, $format, array $context)
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer instanceof NormalizerInterface && $normalizer->supportsNormalization($data, $format, $context)) {
=======
     * @param mixed  $data   Data to get the serializer for
     * @param string $format format name, present to give the option to normalizers to act differently based on formats
     *
     * @return NormalizerInterface|null
     */
    private function getNormalizer($data, $format)
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer instanceof NormalizerInterface && $normalizer->supportsNormalization($data, $format)) {
>>>>>>> web and vendor directory from composer install
                return $normalizer;
            }
        }
    }

    /**
     * Returns a matching denormalizer.
     *
<<<<<<< HEAD
     * @param mixed  $data    Data to restore
     * @param string $class   The expected class to instantiate
     * @param string $format  Format name, present to give the option to normalizers to act differently based on formats
     * @param array  $context Options available to the denormalizer
     *
     * @return DenormalizerInterface|null
     */
    private function getDenormalizer($data, $class, $format, array $context)
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer instanceof DenormalizerInterface && $normalizer->supportsDenormalization($data, $class, $format, $context)) {
=======
     * @param mixed  $data   data to restore
     * @param string $class  the expected class to instantiate
     * @param string $format format name, present to give the option to normalizers to act differently based on formats
     *
     * @return DenormalizerInterface|null
     */
    private function getDenormalizer($data, $class, $format)
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer instanceof DenormalizerInterface && $normalizer->supportsDenormalization($data, $class, $format)) {
>>>>>>> web and vendor directory from composer install
                return $normalizer;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    final public function encode($data, $format, array $context = array())
    {
        return $this->encoder->encode($data, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    final public function decode($data, $format, array $context = array())
    {
        return $this->decoder->decode($data, $format, $context);
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function supportsEncoding($format/*, array $context = array()*/)
    {
        if (\func_num_args() > 1) {
            $context = \func_get_arg(1);
        } else {
            if (__CLASS__ !== \get_class($this)) {
                $r = new \ReflectionMethod($this, __FUNCTION__);
                if (__CLASS__ !== $r->getDeclaringClass()->getName()) {
                    @trigger_error(sprintf('Method %s() will have a second `$context = array()` argument in version 4.0. Not defining it is deprecated since Symfony 3.3.', __METHOD__), E_USER_DEPRECATED);
                }
            }

            $context = array();
        }

        return $this->encoder->supportsEncoding($format, $context);
=======
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed  $data    data to restore
     * @param string $class   the expected class to instantiate
     * @param string $format  format name, present to give the option to normalizers to act differently based on formats
     * @param array  $context The context data for this particular denormalization
     *
     * @return object
     *
     * @throws LogicException
     * @throws UnexpectedValueException
     */
    private function denormalizeObject($data, $class, $format, array $context = array())
    {
        if (!$this->normalizers) {
            throw new LogicException('You must register at least one normalizer to be able to denormalize objects.');
        }

        if ($normalizer = $this->getDenormalizer($data, $class, $format)) {
            return $normalizer->denormalize($data, $class, $format, $context);
        }

        throw new UnexpectedValueException(sprintf('Could not denormalize object of type %s, no supporting normalizer found.', $class));
>>>>>>> web and vendor directory from composer install
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function supportsDecoding($format/*, array $context = array()*/)
    {
        if (\func_num_args() > 1) {
            $context = \func_get_arg(1);
        } else {
            if (__CLASS__ !== \get_class($this)) {
                $r = new \ReflectionMethod($this, __FUNCTION__);
                if (__CLASS__ !== $r->getDeclaringClass()->getName()) {
                    @trigger_error(sprintf('Method %s() will have a second `$context = array()` argument in version 4.0. Not defining it is deprecated since Symfony 3.3.', __METHOD__), E_USER_DEPRECATED);
                }
            }

            $context = array();
        }

        return $this->decoder->supportsDecoding($format, $context);
=======
    public function supportsEncoding($format)
    {
        return $this->encoder->supportsEncoding($format);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDecoding($format)
    {
        return $this->decoder->supportsDecoding($format);
>>>>>>> web and vendor directory from composer install
    }
}
