<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Validator\Constraints;

use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DictionaryValidator extends ConstraintValidator
{
    /**
     * @var DictionaryRegistry
     */
    private $dictionaries;

    public function __construct(DictionaryRegistry $dictionaries)
    {
        $this->dictionaries = $dictionaries;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (false === $constraint instanceof Dictionary) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Dictionary');
        }

        if (null === $value || '' === $value) {
            return;
        }

        $dictionary = $this->dictionaries->get($constraint->name);
        $values     = $dictionary->getKeys();

        if (false === \in_array($value, $values)) {
            $this->context->addViolation(
                $constraint->message,
                ['{{ key }}' => $value, '{{ keys }}' => implode(', ', $values)]
            );
        }
    }
}
