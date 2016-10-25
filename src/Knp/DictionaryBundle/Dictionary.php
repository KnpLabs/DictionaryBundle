<?php

namespace Knp\DictionaryBundle;

interface Dictionary extends \ArrayAccess, \IteratorAggregate, \Serializable
{
    const VALUE        = 'value';
    const VALUE_AS_KEY = 'value_as_key';
    const KEY_VALUE    = 'key_value';
    const CALLABLE     = 'callable';

    /**
     * @return string
     */
    public function getName();

    /**
     * @return mixed[]
     */
    public function getValues();

    /**
     * @return mixed[]
     */
    public function getKeys();
}
