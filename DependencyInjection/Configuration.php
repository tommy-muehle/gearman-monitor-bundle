<?php

namespace EnlightenedDC\GearmanMonitorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package EnlightenedDC\GearmanMonitorBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gearman');

        $rootNode
            ->children()
                ->arrayNode('servers')
                    ->performNoDeepMerging()
                    ->defaultValue([
                        'localhost' =>  [
                            'host'  =>  '127.0.0.1',
                            'port'  =>  '4730',
                        ],
                    ])
                    ->prototype('array')
                        ->children()
                            ->scalarNode('host')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->integerNode('port')
                                ->defaultValue('4730')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
