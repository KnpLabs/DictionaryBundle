<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

class CombinedDictionary implements Dictionary
{
    use Traits\Legacy;

    public function __construct(string $name, array $dictionaries)
    {
        @trigger_error(
            sprintf(
                'Class %s is deprecated since version 2.1, to be removed in 3.0. Use %s instead.',
                __CLASS__,
                Combined::class
            ),
            E_USER_DEPRECATED
        );

        $this->dictionary = new Combined($name, $dictionaries);
    }
}
