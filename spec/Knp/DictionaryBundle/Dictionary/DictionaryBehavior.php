<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

trait DictionaryBehavior
{
    public function it_is_a_dictionary(): void
    {
        $this
            ->shouldImplement(Dictionary::class)
        ;
    }

    public function it_access_to_value_like_an_array(): void
    {
        foreach ($this->getExpectedResult() as $key => $value) {
            $this[$key]->shouldBe($value);
        }
    }

    public function it_provides_keys(): void
    {
        $this
            ->getKeys()
            ->shouldReturn(array_keys($this->getExpectedResult()))
        ;
    }

    public function it_provides_values(): void
    {
        $this
            ->getValues()
            ->shouldReturn(array_values($this->getExpectedResult()))
        ;
    }

    public function it_provides_combination_of_keys_and_values(): void
    {
        $this
            ->shouldYieldLike($this->getExpectedResult())
        ;
    }

    public function it_is_countable(): void
    {
        $this
            ->shouldHaveCount(\count($this->getExpectedResult()))
        ;
    }

    public function it_has_a_name(): void
    {
        $this
            ->getName()
            ->shouldReturn($this->getExpectedName())
        ;
    }

    abstract protected function getExpectedResult(): array;

    abstract protected function getExpectedName(): string;
}
