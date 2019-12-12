<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 */
class Dictionary extends Constraint
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $message = "The key {{ key }}{{ keyType }} doesn't exist in the given dictionary. {{ keys }}{{ keysType }} available.";

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return DictionaryValidator::class;
    }

    /**
     * @return string[]
     */
    public function getRequiredOptions()
    {
        return ['name'];
    }
}
