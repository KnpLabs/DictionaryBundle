<?php

namespace Knp\DictionaryBundle\Dictionary;

class Dictionary extends LazyDictionary
{
    /**
     * @param string  $name
     * @param mixed[] $values
     */
    public function __construct($name, array $values)
    {
        parent::__construct($name, function () use ($values) {
            return $values;
        });
    }
}
