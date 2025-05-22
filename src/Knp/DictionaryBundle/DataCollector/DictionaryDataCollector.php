<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

final class DictionaryDataCollector extends DataCollector
{
    public function collect(Request $request, Response $response, ?\Throwable $throwable = null): void {}

    /**
     * @param array<mixed> $keys
     * @param array<mixed> $values
     */
    public function addDictionary(string $name, array $keys, array $values): void
    {
        $this->data[$name] = array_map(
            static fn ($key, $value): array => ['key' => $key, 'value' => $value],
            $keys,
            $values
        );
    }

    /**
     * @return \Generator<string, array<mixed>>
     */
    public function getDictionaries(): \Generator
    {
        foreach ($this->data as $name => $keyValuePairs) {
            yield $name => $keyValuePairs;
        }
    }

    public function reset(): void {}

    public function getName(): string
    {
        return 'dictionary';
    }
}
