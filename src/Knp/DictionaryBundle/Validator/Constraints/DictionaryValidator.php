<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Validator\Constraints;

use Knp\DictionaryBundle\Dictionary\Collection;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use function gettype;
use function in_array;
use function reset;

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

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        if (false === $constraint instanceof Dictionary) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Dictionary');
        }

        if (null === $value || '' === $value) {
            return;
        }

        $dictionary = $this->dictionaries[$constraint->name];
        $keys       = $dictionary->getKeys();

        $dictionaryFirstType = null;
        if (count($keys)) {
            $dictionaryFirstType = gettype(reset($keys));
        }

        if (false === in_array($value, $keys, true)) {
            $valueType = gettype($value);
            $isTypeDifferent = $valueType !== $dictionaryFirstType;
            $this->context->addViolation(
                $constraint->message,
                [
                    '{{ key }}'  => $value,
                    '{{ keyType }}'  => $isTypeDifferent ? sprintf(' (%s)', $valueType) : '',
                    '{{ keys }}' => implode(', ', $keys),
                    '{{ keysType }}' =>  ($isTypeDifferent ? sprintf(' (%s)', $dictionaryFirstType) : ''),
                ]
            );
        }
    }
}
