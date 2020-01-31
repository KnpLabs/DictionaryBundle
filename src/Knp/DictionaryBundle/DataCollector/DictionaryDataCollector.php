<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DataCollector;

use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Throwable;

final class DictionaryDataCollector extends DataCollector
{
    public function collect(Request $request, Response $response, Throwable $throwable = null): void
    {
    }

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
