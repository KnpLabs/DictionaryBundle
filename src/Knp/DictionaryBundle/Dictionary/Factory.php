<?php

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

interface Factory
{
    public function create(string $name, array $config): Dictionary;

    public function supports(array $config): bool;
}
