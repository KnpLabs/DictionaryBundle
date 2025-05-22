<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\ValueTransformer;

use Exception;
use Knp\DictionaryBundle\ValueTransformer;
use ReflectionClass;

final class Constant implements ValueTransformer
{
    private const PATTERN = '/^(.*)::(.*)$/';

    public function supports(mixed $value): bool
    {
        if (!\is_string($value)) {
            return false;
        }

        $matches = [];

        if (null === $matches = $this->extract($value)) {
            return false;
        }

        [$class, $constant] = $matches;

        $constants = (new ReflectionClass($class))->getConstants();

        return \array_key_exists($constant, $constants);
    }

    public function transform(mixed $value)
    {
        if (null === $matches = $this->extract($value)) {
            throw new Exception("Unable to resolve constant {$value}.");
        }

        [$class, $constant] = $matches;

        return (new ReflectionClass($class))->getConstant($constant);
    }

    /**
     * @return ?array{class-string, string}
     */
    private function extract(string $value): ?array
    {
        if (preg_match(self::PATTERN, $value, $matches)) {
            [, $class, $constant] = $matches;

            return class_exists($class) || interface_exists($class)
                ? [$class, $constant]
                : null;
        }

        return null;
    }
}
