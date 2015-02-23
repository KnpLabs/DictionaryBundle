<?php

namespace Knp\DictionaryBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 */
class Dictionary extends Constraint
{
    public $name;
    public $message = 'The key {{ key }} doesn\'t exist in the given dictionary. {{ keys }} available.';

    public function validatedBy()
    {
        return 'knp_dictionary.dictionary_validator';
    }

    public function getRequiredOptions()
    {
        return array('name');
    }
}
