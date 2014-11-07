<?php

namespace Knp\DictionaryBundle\Dictionary;

class Dictionary
{
    const VALUE        = 'value';

    const VALUE_AS_KEY = 'value_as_key';

    const KEY_VALUE    = 'key_value';

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
