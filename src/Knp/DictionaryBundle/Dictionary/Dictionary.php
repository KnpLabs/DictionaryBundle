<?php

namespace Knp\DictionaryBundle\Dictionary;

class Dictionary
{
    const VALUE = 'value';

    const VALUE_AS_KEY = 'value_as_key';

    const KEY_VALUE = 'key_value';

    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed[]
     */
    private $values = array();

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed[]
     */
    public function getValues()
    {
        return $this->values;
    }
}
