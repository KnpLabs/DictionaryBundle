<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Assert\Assert;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory\Aggregate;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DictionaryBuildingPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryBuildingPass::class);
    }

    function it_builds_a_value_as_key_dictionary_from_the_config(ContainerBuilder $container)
    {
        $config = [
            'dictionaries' => [
                'dico1' => [
                    'type'    => Dictionary::VALUE_AS_KEY,
                    'content' => ['foo', 'bar', 'baz'],
                ],
            ],
        ];

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1',
            Argument::that(function ($definition) {
                Assert::that($definition->getClass())->eq(Dictionary::class);

                $factory = $definition->getFactory();

                Assert::that($factory[0]->__toString())->eq(Aggregate::class);

                Assert::that($factory[1])->eq('create');

                Assert::that($definition->getArguments())->eq([
                    'dico1',
                    [
                        'type'    => Dictionary::VALUE_AS_KEY,
                        'content' => ['foo', 'bar', 'baz'],
                    ],
                ]);

                Assert::that($definition->getTags())->eq([DictionaryRegistrationPass::TAG_DICTIONARY => [[]]]);

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_value_dictionary_from_the_config(ContainerBuilder $container)
    {
        $config = [
            'dictionaries' => [
                'dico1' => [
                    'type'    => Dictionary::VALUE,
                    'content' => [2 => 'foo', 10 => 'bar', 100 => 'baz'],
                ],
            ],
        ];

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1',
            Argument::that(function ($definition) {
                Assert::that($definition->getClass())->eq('Knp\DictionaryBundle\Dictionary');

                $factory = $definition->getFactory();

                Assert::that($factory[0]->__toString())->eq(Aggregate::class);

                Assert::that($factory[1])->eq('create');

                Assert::that($definition->getArguments())->eq([
                    'dico1',
                    [
                        'type'    => Dictionary::VALUE,
                        'content' => [2 => 'foo', 10 => 'bar', 100 => 'baz'],
                    ],
                ]);

                Assert::that($definition->getTags(), [DictionaryRegistrationPass::TAG_DICTIONARY => [[]]]);

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_key_value_dictionary_from_the_config(ContainerBuilder $container)
    {
        $config = [
            'dictionaries' => [
                'dico1' => [
                    'type'    => Dictionary::KEY_VALUE,
                    'content' => [2 => 'foo', 10 => 'bar', 100 => 'baz'],
                ],
            ],
        ];

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1',
            Argument::that(function ($definition) {
                Assert::that($definition->getClass())->eq(Dictionary::class);

                $factory = $definition->getFactory();

                Assert::that($factory[0]->__toString())->eq(Aggregate::class);

                Assert::that($factory[1])->eq('create');

                Assert::that($definition->getArguments())->eq([
                    'dico1',
                    [
                        'type'    => Dictionary::KEY_VALUE,
                        'content' => [2 => 'foo', 10 => 'bar', 100 => 'baz'],
                    ],
                ]);

                Assert::that($definition->getTags())->eq([DictionaryRegistrationPass::TAG_DICTIONARY => [[]]]);

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }
}
