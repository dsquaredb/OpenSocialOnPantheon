<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Exception;

/**
<<<<<<< HEAD
=======
 * ConflictHttpException.
 *
>>>>>>> web and vendor directory from composer install
 * @author Ben Ramsey <ben@benramsey.com>
 */
class ConflictHttpException extends HttpException
{
    /**
<<<<<<< HEAD
=======
     * Constructor.
     *
>>>>>>> web and vendor directory from composer install
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(409, $message, $previous, array(), $code);
    }
}
