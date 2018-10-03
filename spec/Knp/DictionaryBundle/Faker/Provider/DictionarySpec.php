<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Faker\Provider;

use Assert\Assert;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Faker;
use PhpSpec\ObjectBehavior;

class DictionarySpec extends ObjectBehavior
{
    /**
     * @var Dictionary\Collection
     */
    private $dictionaries;

    function let()
    {
        $this->dictionaries = new Dictionary\Collection();

        $this->beConstructedWith($this->dictionaries);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Faker\Provider\Dictionary::class);
    }

    function it_can_generates_random_values(Dictionary $dictionary)
    {
        $dictionary->getKeys()->willReturn(['foo', 'bar', 'baz']);
        $dictionary->getName()->willReturn('the_dico');

        $this->dictionaries->add($dictionary->getWrappedObject());

        $this->dictionary('the_dico')->shouldBeOneOf(['foo', 'bar', 'baz']);
    }

    function it_can_generates_unique_random_values(Dictionary $dictionary)
    {
        $dictionary->getKeys()->willReturn(['foo', 'bar', 'baz']);
        $dictionary->getName()->willReturn('the_dico');

        $this->dictionaries->add($dictionary->getWrappedObject());

        $this->unique()->dictionary('the_dico')->shouldBeOneOf(['foo', 'bar', 'baz']);
    }

    public function getMatchers(): array
    {
        return [
            'beOneOf' => function (string $value, array $array) {
                Assert::that($value)->inArray($array);

                return true;
            },
        ];
    }
}
