<?php

declare(strict_types=1);

namespace App\Connector\MySQL;

use App\Connector\Configuration as ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConnectionConfigurationNode(TreeBuilder $builder): void
    {
        $builder->getRootNode()
            ->children()
                ->scalarNode('host')->cannotBeEmpty()->example('localhost')->end()
                ->integerNode('port')->defaultValue(3306)->end()
                ->scalarNode('user')->cannotBeEmpty()->end()
                ->scalarNode('pass')->cannotBeEmpty()->end()
                ->scalarNode('url')->cannotBeEmpty()->end()
            ->end()
            ->validate()
                ->ifTrue(function ($values) {
                    return !isset($values['url']) && !isset($values['host'], $values['port'], $values['user'], $values['pass']);
                })
                ->thenInvalid('please provide valid credentials (either an URL or host, port, user and pass)!')
                ->ifTrue(function ($values) {
                    return isset($values['url'], $values['host'], $values['port'], $values['user'], $values['pass']);
                })
                ->thenInvalid('you provided both an URL and host, port, user and pass - please provide just one!')
            ->end()
        ;
    }

    public function getMonitoringConfigurationNode(TreeBuilder $builder): void
    {
        $builder->getRootNode()
            ->children()
                ->scalarNode('sql')->end()
            ->end()
        ;
    }
}
