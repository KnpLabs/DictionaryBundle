<?php

namespace Knp\DictionaryBundle\Dictionary;

class Dictionary extends SimpleDictionary
{
    /**
     * @param string  $name
     * @param mixed[] $values
     *
     * @deprecated Knp\DictionaryBundle\Dictionary\Dictionary is deprecated and will be unsupported as of version 2.1, use Knp\DictionaryBundle\Dictionary\SimpleDictionary instead.
     */
    public function __construct($name, array $values)
    {
        parent::__construct($name, $values);
    }
}
