<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory\Aggregate;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webmozart\Assert\Assert;

final class DictionaryBuildingPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryBuildingPass::class);
    }

    function it_builds_a_value_as_key_dictionary_from_the_config(
        ContainerBuilder $container
    ) {
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
            Argument::that(function ($definition): bool {
                Assert::eq($definition->getClass(), Dictionary::class);

                $factory = $definition->getFactory();

                Assert::eq((string) $factory[0], Aggregate::class);

                Assert::eq($factory[1], 'create');

                Assert::eq(
                    $definition->getArguments(),
                    [
                        'dico1',
                        [
                            'type'    => Dictionary::VALUE_AS_KEY,
                            'content' => ['foo', 'bar', 'baz'],
                        ],
                    ]
                );

                Assert::eq(
                    $definition->getTags(),
                    [DictionaryRegistrationPass::TAG_DICTIONARY => [[]]]
                );

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_value_dictionary_from_the_config(
        ContainerBuilder $container
    ) {
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
            Argument::that(function ($definition): bool {
                Assert::eq($definition->getClass(), Dictionary::class);

                $factory = $definition->getFactory();

                Assert::eq((string) $factory[0], Aggregate::class);

                Assert::eq($factory[1], 'create');

                Assert::eq(
                    $definition->getArguments(),
                    [
                        'dico1',
                        [
                            'type'    => Dictionary::VALUE,
                            'content' => [2 => 'foo', 10 => 'bar', 100 => 'baz'],
                        ],
                    ]
                );

                Assert::eq($definition->getTags(), [DictionaryRegistrationPass::TAG_DICTIONARY => [[]]]);

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_key_value_dictionary_from_the_config(
        ContainerBuilder $container
    ) {
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
            Argument::that(function ($definition): bool {
                Assert::eq($definition->getClass(), Dictionary::class);

                $factory = $definition->getFactory();

                Assert::eq((string) $factory[0], Aggregate::class);

                Assert::eq($factory[1], 'create');

                Assert::eq(
                    $definition->getArguments(),
                    [
                        'dico1',
                        [
                            'type'    => Dictionary::KEY_VALUE,
                            'content' => [2 => 'foo', 10 => 'bar', 100 => 'baz'],
                        ],
                    ]
                );

                Assert::eq($definition->getTags(), [DictionaryRegistrationPass::TAG_DICTIONARY => [[]]]);

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }
}
