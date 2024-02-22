<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary\Simple;
use PhpSpec\ObjectBehavior;

final class SimpleSpec extends ObjectBehavior
{
    use DictionaryBehavior;

    function let()
    {
        $this->beConstructedWith('foo', [
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Simple::class);
    }

    protected function getExpectedResult(): array
    {
        return [
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ];
    }

    protected function getExpectedName(): string
    {
        return 'foo';
    }
}
