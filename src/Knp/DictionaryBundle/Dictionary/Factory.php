<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

interface Factory
{
    /**
     * @param mixed[] $config
     *
     * @return Dictionary<int|string, mixed>
     */
    public function create(string $name, array $config): Dictionary;

    /**
     * @param mixed[] $config
     */
    public function supports(array $config): bool;
}
