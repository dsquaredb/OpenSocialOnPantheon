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
use Egulias\EmailValidator\Validation\EmailValidation;
use Egulias\EmailValidator\Validation\NoRFCWarningsValidation;
=======
use Symfony\Component\Validator\Context\ExecutionContextInterface;
>>>>>>> web and vendor directory from composer install
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\RuntimeException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class EmailValidator extends ConstraintValidator
{
<<<<<<< HEAD
    private $isStrict;

    /**
     * @param bool $strict
     */
=======
    /**
     * @var bool
     */
    private $isStrict;

>>>>>>> web and vendor directory from composer install
    public function __construct($strict = false)
    {
        $this->isStrict = $strict;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Email) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Email');
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        if (null === $constraint->strict) {
            $constraint->strict = $this->isStrict;
        }

        if ($constraint->strict) {
<<<<<<< HEAD
            if (!class_exists('\Egulias\EmailValidator\EmailValidator')) {
                throw new RuntimeException('Strict email validation requires egulias/email-validator ~1.2|~2.0');
=======
            if (!class_exists('\Egulias\EmailValidator\EmailValidator') || interface_exists('\Egulias\EmailValidator\Validation\EmailValidation')) {
                throw new RuntimeException('Strict email validation requires egulias/email-validator:~1.2');
>>>>>>> web and vendor directory from composer install
            }

            $strictValidator = new \Egulias\EmailValidator\EmailValidator();

<<<<<<< HEAD
            if (interface_exists(EmailValidation::class) && !$strictValidator->isValid($value, new NoRFCWarningsValidation())) {
=======
            if (!$strictValidator->isValid($value, false, true)) {
                if ($this->context instanceof ExecutionContextInterface) {
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ value }}', $this->formatValue($value))
                        ->setCode(Email::INVALID_FORMAT_ERROR)
                        ->addViolation();
                } else {
                    $this->buildViolation($constraint->message)
                        ->setParameter('{{ value }}', $this->formatValue($value))
                        ->setCode(Email::INVALID_FORMAT_ERROR)
                        ->addViolation();
                }

                return;
            }
        } elseif (!preg_match('/^.+\@\S+\.\S+$/', $value)) {
            if ($this->context instanceof ExecutionContextInterface) {
>>>>>>> web and vendor directory from composer install
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::INVALID_FORMAT_ERROR)
                    ->addViolation();
<<<<<<< HEAD

                return;
            } elseif (!interface_exists(EmailValidation::class) && !$strictValidator->isValid($value, false, true)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::INVALID_FORMAT_ERROR)
                    ->addViolation();

                return;
            }
        } elseif (!preg_match('/^.+\@\S+\.\S+$/', $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(Email::INVALID_FORMAT_ERROR)
                ->addViolation();
=======
            } else {
                $this->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::INVALID_FORMAT_ERROR)
                    ->addViolation();
            }
>>>>>>> web and vendor directory from composer install

            return;
        }

<<<<<<< HEAD
        $host = (string) substr($value, strrpos($value, '@') + 1);
=======
        $host = substr($value, strrpos($value, '@') + 1);
>>>>>>> web and vendor directory from composer install

        // Check for host DNS resource records
        if ($constraint->checkMX) {
            if (!$this->checkMX($host)) {
<<<<<<< HEAD
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::MX_CHECK_FAILED_ERROR)
                    ->addViolation();
=======
                if ($this->context instanceof ExecutionContextInterface) {
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ value }}', $this->formatValue($value))
                        ->setCode(Email::MX_CHECK_FAILED_ERROR)
                        ->addViolation();
                } else {
                    $this->buildViolation($constraint->message)
                        ->setParameter('{{ value }}', $this->formatValue($value))
                        ->setCode(Email::MX_CHECK_FAILED_ERROR)
                        ->addViolation();
                }
>>>>>>> web and vendor directory from composer install
            }

            return;
        }

        if ($constraint->checkHost && !$this->checkHost($host)) {
<<<<<<< HEAD
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(Email::HOST_CHECK_FAILED_ERROR)
                ->addViolation();
=======
            if ($this->context instanceof ExecutionContextInterface) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::HOST_CHECK_FAILED_ERROR)
                    ->addViolation();
            } else {
                $this->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::HOST_CHECK_FAILED_ERROR)
                    ->addViolation();
            }
>>>>>>> web and vendor directory from composer install
        }
    }

    /**
     * Check DNS Records for MX type.
     *
     * @param string $host Host
     *
     * @return bool
     */
    private function checkMX($host)
    {
<<<<<<< HEAD
        return '' !== $host && checkdnsrr($host, 'MX');
=======
        return checkdnsrr($host, 'MX');
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Check if one of MX, A or AAAA DNS RR exists.
     *
     * @param string $host Host
     *
     * @return bool
     */
    private function checkHost($host)
    {
<<<<<<< HEAD
        return '' !== $host && ($this->checkMX($host) || (checkdnsrr($host, 'A') || checkdnsrr($host, 'AAAA')));
=======
        return $this->checkMX($host) || (checkdnsrr($host, 'A') || checkdnsrr($host, 'AAAA'));
>>>>>>> web and vendor directory from composer install
    }
}
