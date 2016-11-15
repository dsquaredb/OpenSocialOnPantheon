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
class RangeValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Range) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Range');
        }

        if (null === $value) {
            return;
        }

<<<<<<< HEAD
        if (!is_numeric($value) && !$value instanceof \DateTimeInterface) {
            $this->context->buildViolation($constraint->invalidMessage)
                ->setParameter('{{ value }}', $this->formatValue($value, self::PRETTY_DATE))
                ->setCode(Range::INVALID_CHARACTERS_ERROR)
                ->addViolation();
=======
        if (!is_numeric($value) && !$value instanceof \DateTime && !$value instanceof \DateTimeInterface) {
            if ($this->context instanceof ExecutionContextInterface) {
                $this->context->buildViolation($constraint->invalidMessage)
                    ->setParameter('{{ value }}', $this->formatValue($value, self::PRETTY_DATE))
                    ->setCode(Range::INVALID_CHARACTERS_ERROR)
                    ->addViolation();
            } else {
                $this->buildViolation($constraint->invalidMessage)
                    ->setParameter('{{ value }}', $this->formatValue($value, self::PRETTY_DATE))
                    ->setCode(Range::INVALID_CHARACTERS_ERROR)
                    ->addViolation();
            }
>>>>>>> web and vendor directory from composer install

            return;
        }

        $min = $constraint->min;
        $max = $constraint->max;

        // Convert strings to DateTimes if comparing another DateTime
        // This allows to compare with any date/time value supported by
        // the DateTime constructor:
        // http://php.net/manual/en/datetime.formats.php
<<<<<<< HEAD
        if ($value instanceof \DateTimeInterface) {
=======
        if ($value instanceof \DateTime || $value instanceof \DateTimeInterface) {
>>>>>>> web and vendor directory from composer install
            if (is_string($min)) {
                $min = new \DateTime($min);
            }

            if (is_string($max)) {
                $max = new \DateTime($max);
            }
        }

        if (null !== $constraint->max && $value > $max) {
<<<<<<< HEAD
            $this->context->buildViolation($constraint->maxMessage)
                ->setParameter('{{ value }}', $this->formatValue($value, self::PRETTY_DATE))
                ->setParameter('{{ limit }}', $this->formatValue($max, self::PRETTY_DATE))
                ->setCode(Range::TOO_HIGH_ERROR)
                ->addViolation();
=======
            if ($this->context instanceof ExecutionContextInterface) {
                $this->context->buildViolation($constraint->maxMessage)
                    ->setParameter('{{ value }}', $this->formatValue($value, self::PRETTY_DATE))
                    ->setParameter('{{ limit }}', $this->formatValue($max, self::PRETTY_DATE))
                    ->setCode(Range::TOO_HIGH_ERROR)
                    ->addViolation();
            } else {
                $this->buildViolation($constraint->maxMessage)
                    ->setParameter('{{ value }}', $this->formatValue($value, self::PRETTY_DATE))
                    ->setParameter('{{ limit }}', $this->formatValue($max, self::PRETTY_DATE))
                    ->setCode(Range::TOO_HIGH_ERROR)
                    ->addViolation();
            }
>>>>>>> web and vendor directory from composer install

            return;
        }

        if (null !== $constraint->min && $value < $min) {
<<<<<<< HEAD
            $this->context->buildViolation($constraint->minMessage)
                ->setParameter('{{ value }}', $this->formatValue($value, self::PRETTY_DATE))
                ->setParameter('{{ limit }}', $this->formatValue($min, self::PRETTY_DATE))
                ->setCode(Range::TOO_LOW_ERROR)
                ->addViolation();
=======
            if ($this->context instanceof ExecutionContextInterface) {
                $this->context->buildViolation($constraint->minMessage)
                    ->setParameter('{{ value }}', $this->formatValue($value, self::PRETTY_DATE))
                    ->setParameter('{{ limit }}', $this->formatValue($min, self::PRETTY_DATE))
                    ->setCode(Range::TOO_LOW_ERROR)
                    ->addViolation();
            } else {
                $this->buildViolation($constraint->minMessage)
                    ->setParameter('{{ value }}', $this->formatValue($value, self::PRETTY_DATE))
                    ->setParameter('{{ limit }}', $this->formatValue($min, self::PRETTY_DATE))
                    ->setCode(Range::TOO_LOW_ERROR)
                    ->addViolation();
            }
>>>>>>> web and vendor directory from composer install
        }
    }
}
