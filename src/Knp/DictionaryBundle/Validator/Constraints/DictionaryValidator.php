<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Validator\Constraints;

use Knp\DictionaryBundle\Dictionary\Collection;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class DictionaryValidator extends ConstraintValidator
{
    /**
     * @var Collection
     */
    private $dictionaries;

    public function __construct(Collection $dictionaries)
    {
        $this->dictionaries = $dictionaries;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Dictionary) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Dictionary');
        }

        if (null === $value || '' === $value) {
            return;
        }

        $dictionary = $this->dictionaries[$constraint->name];
        $values     = $dictionary->getKeys();

        if (!\in_array($value, $values, true)) {
            $this->context->addViolation(
                $constraint->message,
                [
                    '{{ key }}'  => $this->varToString($value),
                    '{{ keys }}' => implode(
                        ', ',
                        array_map(
                            [$this, 'varToString'],
                            $values
                        )
                    ),
                ]
            );
        }
    }

    /**
     * @param mixed $var
     */
    private function varToString($var): string
    {
        if (null === $var) {
            return 'null';
        }

        if (\is_string($var)) {
            return '"'.$var.'"';
        }

        if (\is_bool($var)) {
            return $var ? 'true' : 'false';
        }

        if (\is_float($var)) {
            return 0.0 === $var
                ? '0.0'
                : (string) $var
            ;
        }

        return (string) $var;
    }
}
