<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator;

/**
 * Prepares an object for validation.
 *
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
 * Concrete implementations of this interface are used by {@link Validator\ContextualValidatorInterface}
=======
 * Concrete implementations of this interface are used by {@link ValidationVisitorInterface}
>>>>>>> web and vendor directory from composer install
=======
 * Concrete implementations of this interface are used by {@link Validator\ContextualValidatorInterface}
>>>>>>> Update Open Social to 8.x-2.1
=======
 * Concrete implementations of this interface are used by {@link ValidationVisitorInterface}
>>>>>>> revert Open Social update
=======
 * Concrete implementations of this interface are used by {@link Validator\ContextualValidatorInterface}
>>>>>>> updating open social
 * to initialize objects just before validating them.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
interface ObjectInitializerInterface
{
    /**
     * Initializes an object just before validation.
     *
     * @param object $object The object to validate
     */
    public function initialize($object);
}
