<?php

declare(strict_types=1);

namespace spec\PHPSpec;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\BasicMatcher;

final class OneOfMatcher extends BasicMatcher
{
    public function supports(string $name, $subject, array $arguments): bool
    {
        return 'beOneOf' === $name;
    }

    protected function matches($subject, array $arguments): bool
    {
        if (1 === \count($arguments) && \is_array(current($arguments))) {
            $arguments = current($arguments);
        }

        return \in_array($subject, $arguments, true);
    }

    protected function getFailureException(string $name, $subject, array $arguments): FailureException
    {
        if (1 === \count($arguments) && \is_array(current($arguments))) {
            $arguments = current($arguments);
        }

        return new FailureException(
            sprintf(
                '"%s" is not one of ["%s"]',
                $subject,
                implode('", "', $arguments)
            )
        );
    }

    protected function getNegativeFailureException(string $name, $subject, array $arguments): FailureException
    {
        if (1 === \count($arguments) && \is_array(current($arguments))) {
            $arguments = current($arguments);
        }

        return new FailureException(
            sprintf(
                '"%s" is one of ["%s"]',
                $subject,
                implode('", "', $arguments)
            )
        );
    }
}
