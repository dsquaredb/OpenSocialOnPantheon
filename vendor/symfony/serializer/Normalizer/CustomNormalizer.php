<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer\Normalizer;

<<<<<<< HEAD
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

/**
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class CustomNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    use ObjectToPopulateTrait;
    use SerializerAwareTrait;

    private $cache = array();

=======
/**
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class CustomNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface
{
>>>>>>> web and vendor directory from composer install
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return $object->normalize($this->serializer, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
<<<<<<< HEAD
        $object = $this->extractObjectToPopulate($class, $context) ?: new $class();
=======
        $object = new $class();
>>>>>>> web and vendor directory from composer install
        $object->denormalize($this->serializer, $data, $format, $context);

        return $object;
    }

    /**
     * Checks if the given class implements the NormalizableInterface.
     *
     * @param mixed  $data   Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof NormalizableInterface;
    }

    /**
<<<<<<< HEAD
     * Checks if the given class implements the DenormalizableInterface.
=======
     * Checks if the given class implements the NormalizableInterface.
>>>>>>> web and vendor directory from composer install
     *
     * @param mixed  $data   Data to denormalize from
     * @param string $type   The class to which the data should be denormalized
     * @param string $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
<<<<<<< HEAD
        if (isset($this->cache[$type])) {
            return $this->cache[$type];
        }

        if (!class_exists($type)) {
            return $this->cache[$type] = false;
        }

        return $this->cache[$type] = is_subclass_of($type, 'Symfony\Component\Serializer\Normalizer\DenormalizableInterface');
=======
        if (!class_exists($type)) {
            return false;
        }

        return is_subclass_of($type, 'Symfony\Component\Serializer\Normalizer\DenormalizableInterface');
>>>>>>> web and vendor directory from composer install
    }
}
