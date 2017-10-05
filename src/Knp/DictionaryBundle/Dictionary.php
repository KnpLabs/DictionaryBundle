<?php

namespace Knp\DictionaryBundle;

use ArrayAccess;
use IteratorAggregate;

interface Dictionary extends ArrayAccess, IteratorAggregate
{
    const VALUE        = 'value';
    const VALUE_AS_KEY = 'value_as_key';
    const KEY_VALUE    = 'key_value';

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
