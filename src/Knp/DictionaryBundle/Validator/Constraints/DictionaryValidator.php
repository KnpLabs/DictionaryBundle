<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Validator\Constraints;

use Exception;
use Knp\DictionaryBundle\Dictionary\Collection;
use Symfony\Component\Validator\ConstraintValidator;

final class DictionaryValidator extends ConstraintValidator
{
    use DictionaryValidator\SymfonyCompatibilityTrait;

    public function __construct(private Collection $dictionaries)
    {
    }

    private function varToString(mixed $var): string
    {
        if (null === $var) {
            return 'null';
        }

        if (\is_string($var)) {
            return '"'.$var.'"';
        }

        if (\is_bool($var)) {
            return $var ? 'true' : 'false';
        }

        if (\is_float($var)) {
            return 0.0 === $var
                ? '0.0'
                : (string) $var
            ;
        }

        if (\is_object($var) && method_exists($var, '__toString')) {
            return $var->__toString();
        }

        if (settype($var, 'string')) {
            /**
             * @var string $var
             */
            return $var;
        }

        throw new Exception('Unable to transform var to string.');
    }
}
