<?php

namespace Knp\DictionaryBundle\Dictionary;

class StaticDictionary extends LazyDictionary
{
    /**
     * @param string  $name
     * @param mixed[] $values
     */
    public function __construct($name, array $values)
    {
        $this->name   = $name;
        $this->values = $values;
    }

    /**
     * {@inheritdoc}
     */
    protected function hydrate()
    {
        return;
    }
}
