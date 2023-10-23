<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @var string
     */
    private const CONFIG_NAME = 'knp_dictionary';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder  = new TreeBuilder(self::CONFIG_NAME);
        $rootNode = $builder->getRootNode();

        $rootNode
            ->children()
            ->arrayNode('dictionaries')
                ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->beforeNormalization()
                            ->always()
                            ->then(static function ($values) {
                                if (false === \array_key_exists('type', $values)) {
                                    if (false === \array_key_exists('content', $values)) {
                                        return ['type' => 'value', 'content' => $values];
                                    }

                                    return array_merge($values, ['type' => 'value']);
                                }

                                return $values;
                            })
                        ->end()
                        ->children()
                            ->scalarNode('type')->defaultValue('value')->end()
                            ->scalarNode('extends')->end()
                            ->arrayNode('dictionaries')
                                ->normalizeKeys(false)->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('content')
                                ->normalizeKeys(false)->prototype('scalar')->end()
                            ->end()
                            ->scalarNode('service')->end()
                            ->scalarNode('method')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }
}
