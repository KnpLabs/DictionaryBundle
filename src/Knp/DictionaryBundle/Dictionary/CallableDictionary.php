<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

class CallableDictionary implements Dictionary
{
    use Traits\Legacy;

    public function __construct(string $name, callable $callable, array $callableArgs = [])
    {
        @trigger_error(
            sprintf(
                'Class %s is deprecated since version 2.1, to be removed in 3.0. Use %s instead.',
                __CLASS__,
                Invokable::class
            ),
            E_USER_DEPRECATED
        );

        $this->dictionary = new Invokable($name, $callable, $callableArgs);
    }
}
