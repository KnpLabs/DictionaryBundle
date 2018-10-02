<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle;

use ArrayAccess;
use IteratorAggregate;

interface Dictionary extends ArrayAccess, IteratorAggregate
{
    const VALUE        = 'value';
    const VALUE_AS_KEY = 'value_as_key';
    const KEY_VALUE    = 'key_value';

    public function getName(): string;

    /**
     * @return mixed[]
     */
    public function getValues(): array;

    /**
     * @return mixed[]
     */
    public function getKeys(): array;
}
