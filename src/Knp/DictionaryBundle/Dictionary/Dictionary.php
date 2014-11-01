<?php

namespace Knp\DictionaryBundle\Dictionary;

class Dictionary
{
    const NATURALLY_INDEXED = 'naturally_indexed';

    const INDEXED           = 'indexed';

    const VALUE_INDEXED     = 'value_indexed';

    private $values = array();

    private $name;

    public function __construct($name, array $values)
    {
        $this->name   = $name;
        $this->values = $values;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getName()
    {
        return $this->name;
    }
}
