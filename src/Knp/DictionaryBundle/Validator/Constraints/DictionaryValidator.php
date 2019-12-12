<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Validator\Constraints;

use Knp\DictionaryBundle\Dictionary\Collection;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DictionaryValidator extends ConstraintValidator
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
            $valueType = gettype($value);
            $dictionaryFirstType = gettype($values[0]);
            $diffType = $valueType !== $dictionaryFirstType;
            $this->context->addViolation(
                $constraint->message,
                [
                    '{{ key }}'  => $value,
                    '{{ keyType }}'  => $diffType ? sprintf(' (%s)', $valueType) : '',
                    '{{ keys }}' => implode(', ', $values),
                    '{{ keysType }}' =>  ($diffType ? sprintf(' (%s)', $dictionaryFirstType) : ''),
                ]
            );
        }
    }
}
