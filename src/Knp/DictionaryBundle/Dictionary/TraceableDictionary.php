<?php

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary;

class TraceableDictionary implements Dictionary
{
    use Traits\DictionaryWrapper;

    public function __construct(Dictionary $dictionary, DictionaryDataCollector $collector)
    {
        $this->dictionary = new Traceable($dictionary, $collector);

        @trigger_error(
            sprintf(
                'Class %s is deprecated since version 2.1, to be removed in 3.0. Use %s instead.',
                __CLASS__,
                Traceable::class
            ),
            E_USER_DEPRECATED
        );
    }
}
