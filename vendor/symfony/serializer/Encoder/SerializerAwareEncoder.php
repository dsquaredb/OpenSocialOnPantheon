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

<<<<<<< HEAD
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;
=======
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
>>>>>>> web and vendor directory from composer install

/**
 * SerializerAware Encoder implementation.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
<<<<<<< HEAD
 *
 * @deprecated since version 3.2, to be removed in 4.0. Use the SerializerAwareTrait instead.
 */
abstract class SerializerAwareEncoder implements SerializerAwareInterface
{
    use SerializerAwareTrait;
=======
 */
abstract class SerializerAwareEncoder implements SerializerAwareInterface
{
    protected $serializer;

    /**
     * {@inheritdoc}
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
>>>>>>> web and vendor directory from composer install
}
