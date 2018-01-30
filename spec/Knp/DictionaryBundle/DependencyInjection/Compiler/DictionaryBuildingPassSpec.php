<?php

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\Dictionary;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webmozart\Assert\Assert;

class DictionaryBuildingPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass');
    }

    function it_builds_a_value_as_key_dictionary_form_the_config(
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
            Argument::that(function ($definition) {
                Assert::eq($definition->getClass(), 'Knp\DictionaryBundle\Dictionary');

                $factory = $definition->getFactory();

                Assert::eq($factory[0]->__toString(), 'knp_dictionary.dictionary.factory.factory_aggregate');

                Assert::eq($factory[1], 'create');

                Assert::eq($definition->getArguments(), [
                    'dico1',
                    [
                        'type'    => Dictionary::VALUE_AS_KEY,
                        'content' => ['foo', 'bar', 'baz'],
                    ],
                ]);

                Assert::eq($definition->getTags(), [DictionaryRegistrationPass::TAG_DICTIONARY => [[]]]);

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_value_dictionary_form_the_config(
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
            Argument::that(function ($definition) {
                Assert::eq($definition->getClass(), 'Knp\DictionaryBundle\Dictionary');

                $factory = $definition->getFactory();

                Assert::eq($factory[0]->__toString(), 'knp_dictionary.dictionary.factory.factory_aggregate');

                Assert::eq($factory[1], 'create');

                Assert::eq($definition->getArguments(), [
                    'dico1',
                    [
                        'type'    => Dictionary::VALUE,
                        'content' => [2 => 'foo', 10 => 'bar', 100 => 'baz'],
                    ],
                ]);

                Assert::eq($definition->getTags(), [DictionaryRegistrationPass::TAG_DICTIONARY => [[]]]);

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_key_value_dictionary_form_the_config(
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
            Argument::that(function ($definition) {
                Assert::eq($definition->getClass(), 'Knp\DictionaryBundle\Dictionary');

                $factory = $definition->getFactory();

                Assert::eq($factory[0]->__toString(), 'knp_dictionary.dictionary.factory.factory_aggregate');

                Assert::eq($factory[1], 'create');

                Assert::eq($definition->getArguments(), [
                    'dico1',
                    [
                        'type'    => Dictionary::KEY_VALUE,
                        'content' => [2 => 'foo', 10 => 'bar', 100 => 'baz'],
                    ],
                ]);

                Assert::eq($definition->getTags(), [DictionaryRegistrationPass::TAG_DICTIONARY => [[]]]);

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }
}
