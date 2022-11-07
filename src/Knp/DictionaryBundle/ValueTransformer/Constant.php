<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\ValueTransformer;

use Exception;
use Knp\DictionaryBundle\ValueTransformer;
use ReflectionClass;

final class Constant implements ValueTransformer
{
    private const PATTERN = '/^(?P<class>.*)::(?P<constant>.*)$/';

    public function supports($value): bool
    {
        if (!\is_string($value)) {
            return false;
        }

        $matches = [];

        if (null === $matches = $this->extract($value)) {
            return false;
        }

        if (!class_exists($matches['class']) && !interface_exists($matches['class'])) {
            return false;
        }

        $constants = (new ReflectionClass($matches['class']))
            ->getConstants()
        ;

        return \array_key_exists($matches['constant'], $constants);
    }

    public function transform($value)
    {
        if (null === $matches = $this->extract($value)) {
            throw new Exception("Unable to resolve constant {$value}.");
        }

        return (new ReflectionClass($matches['class']))
            ->getConstant($matches['constant'])
        ;
    }

    /**
     * @return ?array{class: class-string, constant: string}
     */
    private function extract(string $value): ?array
    {
        if (preg_match(self::PATTERN, $value, $matches)) {
            /**
             * @var array{class: class-string, constant: string} $matches
             */
            return $matches;
        }

        return null;
    }
}
