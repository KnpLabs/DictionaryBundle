<?php

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

class SimpleDictionary implements Dictionary
{
    use Traits\DictionaryWrapper;

    public function __construct(string $name, array $values)
    {
        $this->dictionary = new Simple($name, $values);

        @trigger_error(
            sprintf(
                'Class %s is deprecated since version 2.1, to be removed in 3.0. Use %s instead.',
                __CLASS__,
                Simple::class
            ),
            E_USER_DEPRECATED
        );
    }
}
