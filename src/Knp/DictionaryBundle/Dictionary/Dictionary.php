<?php

namespace Knp\DictionaryBundle\Dictionary;

class Dictionary
{
    private $values = [];

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
