<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DataCollector;

use Generator;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class DictionaryDataCollector extends DataCollector
{
    use DictionaryDataCollector\SymfonyCompatibilityTrait;

    /**
     * @param array<mixed> $keys
     * @param array<mixed> $values
     */
    public function addDictionary(string $name, array $keys, array $values): void
    {
        $this->data[$name] = array_map(
            function ($key, $value): array {
                return ['key' => $key, 'value' => $value];
            },
            $keys,
            $values
        );
    }

    /**
     * @return Generator<string, array>
     */
    public function getDictionaries(): Generator
    {
        foreach ($this->data as $name => $keyValuePairs) {
            yield $name => $keyValuePairs;
        }
    }

    public function reset(): void
    {
    }

    public function getName()
    {
        return 'dictionary';
    }
}
