<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary;

use Exception;
use Knp\DictionaryBundle\Dictionary\Iterator;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\Assert;

final class IteratorSpec extends ObjectBehavior
{
    use DictionaryBehavior;

    /**
     * @var bool
     */
    private $executed;

    function let()
    {
        $this->executed = false;

        $this->beConstructedWith('foo', $this->execution());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Iterator::class);
    }

    function it_supports_some_array_access_functions()
    {
        $dictionary = $this->getWrappedObject();

        $this['foo']->shouldBe(0);
        $this->shouldHaveKey('foo');

        $this['foo'] = 'test';
        $this['foo']->shouldBe('test');

        unset($dictionary['foo']);
        $this->shouldNotHaveKey('foo');
    }

    function it_is_hydrated_just_once()
    {
        Assert::false($this->executed);

        $this->shouldYieldLike([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);

        Assert::true($this->executed);

        $this->shouldYieldLike([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);

        Assert::true($this->executed);
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

    private function execution(): iterable
    {
        if (!$this->executed) {
            $this->executed = true;

            yield 'foo' => 0;

            yield 'bar' => 1;

            yield 'baz' => 2;

            return;
        }

        throw new Exception('Executed twice.');
    }
}
