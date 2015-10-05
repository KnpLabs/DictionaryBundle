<?php

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
    private $registry;

    /**
     * @param DictionaryRegistry $registry
     */
    public function __construct(DictionaryRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (false === $constraint instanceof Dictionary) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\Dictionary');
        }

        if (false === $constraint->required && empty($value)) {
            return;
        }

        $dictionary = $this->registry->get($constraint->name);
        $values     = $dictionary->getValues();

        if (false === array_key_exists($value, $values)) {
            $this->context->addViolation(
                $constraint->message,
                array('{{ key }}' => $value, '{{ keys }}' => implode(', ', array_keys($values)))
            );
        }
    }
}
