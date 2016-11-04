<?php

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\Dictionary;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

class DictionaryBuildingPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass');
    }

    function it_builds_a_value_as_key_dictionary_from_the_config(ContainerBuilder $container)
    {
        $config = array(
            'dictionaries' => array(
                'dico1' => array(
                    'type'    => Dictionary::VALUE_AS_KEY,
                    'content' => array('foo', 'bar', 'baz'),
                ),
            ),
        );

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1',
            Argument::that(function ($definition) {
                expect($definition->getClass())
                    ->toBe('Knp\DictionaryBundle\Dictionary\LazyDictionary')
                ;

                $factory = $definition->getFactory();

                expect($factory[0]->__toString())
                    ->toBe('knp_dictionary.dictionary.dictionary_factory')
                ;

                expect($factory[1])
                    ->toBe('createFromArray')
                ;

                expect($definition->getArguments())
                    ->toBe(array('dico1', array('foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'), Dictionary::VALUE_AS_KEY))
                ;

                expect($definition->getTags())
                    ->toBe(array(DictionaryRegistrationPass::TAG_DICTIONARY => array(array())))
                ;

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_value_dictionary_from_the_config(ContainerBuilder $container)
    {
        $config = array(
            'dictionaries' => array(
                'dico1' => array(
                    'type'    => Dictionary::VALUE,
                    'content' => array(2 => 'foo', 10 => 'bar', 100 => 'baz'),
                ),
            ),
        );

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1',
            Argument::that(function ($definition) {
                expect($definition->getClass())
                    ->toBe('Knp\DictionaryBundle\Dictionary\LazyDictionary')
                ;

                $factory = $definition->getFactory();

                expect($factory[0]->__toString())
                    ->toBe('knp_dictionary.dictionary.dictionary_factory')
                ;

                expect($factory[1])
                    ->toBe('createFromArray')
                ;

                expect($definition->getArguments())
                    ->toBe(array('dico1', array('foo', 'bar', 'baz'), Dictionary::VALUE))
                ;

                expect($definition->getTags())
                    ->toBe(array(DictionaryRegistrationPass::TAG_DICTIONARY => array(array())))
                ;

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_key_value_dictionary_from_the_config(ContainerBuilder $container)
    {
        $config = array(
            'dictionaries' => array(
                'dico1' => array(
                    'type'    => Dictionary::KEY_VALUE,
                    'content' => array(2 => 'foo', 10 => 'bar', 100 => 'baz'),
                ),
            ),
        );

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1',
            Argument::that(function ($definition) {
                expect($definition->getClass())
                    ->toBe('Knp\DictionaryBundle\Dictionary\LazyDictionary')
                ;

                $factory = $definition->getFactory();

                expect($factory[0]->__toString())
                    ->toBe('knp_dictionary.dictionary.dictionary_factory')
                ;

                expect($factory[1])
                    ->toBe('createFromArray')
                ;

                expect($definition->getArguments())
                    ->toBe(array('dico1', array(2 => 'foo', 10 => 'bar', 100 => 'baz'), Dictionary::KEY_VALUE))
                ;

                expect($definition->getTags())
                    ->toBe(array(DictionaryRegistrationPass::TAG_DICTIONARY => array(array())))
                ;

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_callback_dictionary_from_the_config(ContainerBuilder $container)
    {
        $config = array(
            'dictionaries' => array(
                'dico1' => array(
                    'type'    => Dictionary::CALLABLE_TYPE,
                    'service' => 'app.service.name',
                    'method'  => 'getUnicorns',
                ),
            ),
        );

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1',
            Argument::that(function ($definition) {
                expect($definition->getClass())
                    ->toBe('Knp\DictionaryBundle\Dictionary\LazyDictionary')
                ;

                $factory = $definition->getFactory();

                expect($factory[0]->__toString())
                    ->toBe('knp_dictionary.dictionary.dictionary_factory')
                ;

                expect($factory[1])
                    ->toBe('createFromCallable')
                ;

                $arguments = $definition->getArguments();
                $name = $arguments[0];
                $reference = $arguments[1][0];
                $method = $arguments[1][1];

                expect($name)->toBe('dico1');
                expect($reference)->toHaveType('Symfony\Component\DependencyInjection\Reference');
                expect($reference->__toString())->toBe('app.service.name');
                expect($method)->toBe('getUnicorns');

                expect($definition->getTags())
                    ->toBe(array(DictionaryRegistrationPass::TAG_DICTIONARY => array(array())))
                ;

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_doesnt_supports_other_types(ContainerBuilder $container)
    {
        $config = array(
            'dictionaries' => array(
                'dico1' => array(
                    'type'    => 'yolo',
                    'content' => array(2 => 'foo', 10 => 'bar', 100 => 'baz'),
                ),
            ),
        );

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);

        $this->shouldThrow(new RuntimeException('Unknown dictionary type "yolo"'))->duringProcess($container);
    }
}
