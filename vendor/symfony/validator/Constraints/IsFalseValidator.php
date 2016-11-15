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
class IsFalseValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsFalse) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\IsFalse');
        }

        if (null === $value || false === $value || 0 === $value || '0' === $value) {
            return;
        }

<<<<<<< HEAD
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $this->formatValue($value))
            ->setCode(IsFalse::NOT_FALSE_ERROR)
            ->addViolation();
=======
        if ($this->context instanceof ExecutionContextInterface) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(IsFalse::NOT_FALSE_ERROR)
                ->addViolation();
        } else {
            $this->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(IsFalse::NOT_FALSE_ERROR)
                ->addViolation();
        }
>>>>>>> web and vendor directory from composer install
    }
}
