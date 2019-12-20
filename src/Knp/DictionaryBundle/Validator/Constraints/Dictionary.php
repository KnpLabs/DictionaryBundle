<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 */
final class Dictionary extends Constraint
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $message = "The key {{ key }} doesn't exist in the given dictionary. {{ keys }} available.";

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
