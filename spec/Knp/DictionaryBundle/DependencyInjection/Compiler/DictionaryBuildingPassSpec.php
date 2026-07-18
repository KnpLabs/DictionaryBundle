<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\DependencyInjection\KnpDictionaryExtension;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Dictionary\Factory\Aggregate;
use Knp\DictionaryBundle\Dictionary\Simple;
use Knp\DictionaryBundle\KnpDictionaryBundle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webmozart\Assert\Assert;

final class DictionaryBuildingPassSpec extends ObjectBehavior
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
        $this->expectDico1AliasRegistration($container);

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
        $this->expectDico1AliasRegistration($container);

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
        $this->expectDico1AliasRegistration($container);

        $this->process($container);
    }

    function it_autowires_configured_dictionaries_by_name()
    {
        $container = new ContainerBuilder();
        (new KnpDictionaryExtension())->load([[
            'dictionaries' => [
                'vote'               => ['yes', 'no'],
                'entity_class_icons' => ['user', 'group'],
            ],
        ]], $container);
        (new KnpDictionaryBundle())->build($container);
        $container
            ->register(DictionaryConsumer::class, DictionaryConsumer::class)
            ->setAutowired(true)
            ->setPublic(true)
        ;
        $container->compile();

        $consumer = $container->get(DictionaryConsumer::class);
        Assert::isInstanceOf($consumer, DictionaryConsumer::class);
        Assert::same($consumer->voteDictionary->getName(), 'vote');
        Assert::same($consumer->entityClassIconsDictionary->getName(), 'entity_class_icons');
        Assert::same($consumer->dictionary->getName(), 'vote');
    }

    function it_keeps_invalid_and_ambiguous_dictionary_names_out_of_named_autowiring()
    {
        $container = new ContainerBuilder();
        $container->setParameter('knp_dictionary.configuration', [
            'dictionaries' => [
                '123_status' => [
                    'type'    => Dictionary::VALUE,
                    'content' => ['draft'],
                ],
                'foo-bar' => [
                    'type'    => Dictionary::VALUE,
                    'content' => ['foo'],
                ],
                'foo_bar' => [
                    'type'    => Dictionary::VALUE,
                    'content' => ['bar'],
                ],
            ],
        ]);

        $this->process($container);

        Assert::true($container->hasDefinition('knp_dictionary.dictionary.123_status'));
        Assert::true($container->hasDefinition('knp_dictionary.dictionary.foo-bar'));
        Assert::true($container->hasDefinition('knp_dictionary.dictionary.foo_bar'));
        Assert::false($container->hasAlias(Dictionary::class.' $123StatusDictionary'));
        Assert::false($container->hasAlias(Dictionary::class.' $fooBarDictionary'));
        Assert::false($container->hasDefinition('knp_dictionary.dictionary.123_status.autowiring'));
        Assert::false($container->hasDefinition('knp_dictionary.dictionary.foo-bar.autowiring'));
        Assert::false($container->hasDefinition('knp_dictionary.dictionary.foo_bar.autowiring'));
    }

    function it_preserves_existing_named_autowiring_aliases()
    {
        $container = new ContainerBuilder();
        $container->setParameter('knp_dictionary.configuration', [
            'dictionaries' => [
                'vote' => [
                    'type'    => Dictionary::VALUE,
                    'content' => ['yes', 'no'],
                ],
            ],
        ]);
        $container
            ->register('app.vote_dictionary', Simple::class)
            ->setArguments(['custom_vote', ['custom']])
        ;
        $container->setAlias(Dictionary::class.' $voteDictionary', 'app.vote_dictionary');

        $this->process($container);

        Assert::same(
            (string) $container->getAlias(Dictionary::class.' $voteDictionary'),
            'app.vote_dictionary'
        );
        Assert::false($container->hasDefinition('knp_dictionary.dictionary.vote.autowiring'));
    }

    private function expectDico1AliasRegistration(ContainerBuilder $container): void
    {
        $container->hasAlias(Dictionary::class.' $dico1Dictionary')->willReturn(false);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1.autowiring',
            Argument::that(function ($definition): bool {
                Assert::eq($definition->getClass(), Dictionary::class);
                Assert::eq((string) $definition->getFactory()[0], Collection::class);
                Assert::eq($definition->getFactory()[1], 'offsetGet');
                Assert::eq($definition->getArguments(), ['dico1']);

                return true;
            })
        )->shouldBeCalled();
        $container
            ->registerAliasForArgument(
                'knp_dictionary.dictionary.dico1.autowiring',
                Dictionary::class,
                'dico1.dictionary'
            )
            ->shouldBeCalled()
            ->willReturn(new Alias('knp_dictionary.dictionary.dico1.autowiring'))
        ;
    }
}

final class DictionaryConsumer
{
    public function __construct(
        public readonly Dictionary $voteDictionary,
        public readonly Dictionary $entityClassIconsDictionary,
        #[Target('vote.dictionary')]
        public readonly Dictionary $dictionary,
    ) {}
}
