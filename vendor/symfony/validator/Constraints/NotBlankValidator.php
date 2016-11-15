<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Constraints;

<<<<<<< HEAD
=======
use Symfony\Component\Validator\Context\ExecutionContextInterface;
>>>>>>> web and vendor directory from composer install
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class NotBlankValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof NotBlank) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\NotBlank');
        }

        if (false === $value || (empty($value) && '0' != $value)) {
<<<<<<< HEAD
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(NotBlank::IS_BLANK_ERROR)
                ->addViolation();
=======
            if ($this->context instanceof ExecutionContextInterface) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(NotBlank::IS_BLANK_ERROR)
                    ->addViolation();
            } else {
                $this->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(NotBlank::IS_BLANK_ERROR)
                    ->addViolation();
            }
>>>>>>> web and vendor directory from composer install
        }
    }
}
