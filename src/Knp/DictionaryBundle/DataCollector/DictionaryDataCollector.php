<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DataCollector;

use Generator;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

final class DictionaryDataCollector extends DataCollector
{
    use DictionaryDataCollector\SymfonyCompatibilityTrait;

    /**
     * @param array<mixed> $keys
     * @param array<mixed> $values
     */
    public function addDictionary(string $name, array $keys, array $values): void
    {
        $this->data[$name] = array_map(
            fn ($key, $value): array => ['key' => $key, 'value' => $value],
            $keys,
            $values
        );
    }

    /**
     * @return Generator<string, array<mixed>>
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

    public function getName(): string
    {
        return 'dictionary';
    }
}
