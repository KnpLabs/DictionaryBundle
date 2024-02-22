<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Combined;
use PhpSpec\ObjectBehavior;

final class CombinedSpec extends ObjectBehavior
{
    use DictionaryBehavior;

    function let()
    {
        $this->beConstructedWith(
            'combined_dictionary',
            new Dictionary\Simple(
                'dictionary1',
                [
                    'foo' => 1,
                    'bar' => 2,
                ]
            ),
            new Dictionary\Simple(
                'dictionary2',
                [
                    'bar' => 3,
                    'baz' => 4,
                ]
            ),
            new Dictionary\Simple(
                'dictionary3',
                [
                    'baz' => 5,
                ]
            ),
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Combined::class);
    }

    protected function getExpectedResult(): array
    {
        return [
            'foo' => 1,
            'bar' => 3,
            'baz' => 5,
        ];
    }

    protected function getExpectedName(): string
    {
        return 'combined_dictionary';
    }
}
