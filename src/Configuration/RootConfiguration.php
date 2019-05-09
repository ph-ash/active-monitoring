<?php

declare(strict_types=1);

namespace App\Configuration;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class RootConfiguration implements ConfigurationInterface
{
    private $connectorConfigurations;

    public function __construct(iterable $connectorConfigurations)
    {
        $this->connectorConfigurations = $connectorConfigurations;
    }

    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('phash');
        $node = $builder->getRootNode()->children()->arrayNode('active_monitoring')->children();

        foreach ($this->connectorConfigurations as $connectorConfiguration) {
            $node = $node->append($this->buildConnectorConfiguration($connectorConfiguration));
        }

        $builder = $node->end()->end()->end()->end();
        return $builder;
    }

    private function buildConnectorConfiguration(ConnectorConfiguration $connectorConfiguration): NodeDefinition
    {
        $connectorNode = new TreeBuilder($connectorConfiguration->getConnectorName());

        $connectionTreeBuilder = new TreeBuilder('connection');
        $connectorConfiguration->getConnectionConfigurationNode($connectionTreeBuilder);
        $monitoringTreeBuilder = new TreeBuilder('connector');
        $connectorConfiguration->getMonitoringConfigurationNode($monitoringTreeBuilder);

        $connectorNode->getRootNode()
            ->children()

                // defaults - allow every key as this part won't be validated, but just merged into the deeper "monitorings"
                ->arrayNode('defaults')
                    ->children()
                        ->arrayNode('connection')
                            ->ignoreExtraKeys(false)
                        ->end()
                        ->arrayNode('monitorings')
                            ->ignoreExtraKeys(false)
                        ->end()
                    ->end()
                ->end()

                // actual monitorings for the connector
                ->arrayNode('monitorings')
                    ->isRequired()
                    ->arrayPrototype()
                        ->children()
                            ->append($connectionTreeBuilder->getRootNode()->isRequired())
                            ->append($monitoringTreeBuilder->getRootNode()->isRequired())
                            ->arrayNode('monitoring')
                                ->isRequired()
                                ->children()
                                    ->scalarNode('cron')->isRequired()->cannotBeEmpty()->end()
                                    ->arrayNode('failure_conditions')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                        ->scalarPrototype()->cannotBeEmpty()->end()
                                    ->end()
                                    ->scalarNode('payload')->isRequired()->cannotBeEmpty()->end()
                                    ->integerNode('idleTimeoutInSeconds')->isRequired()->end()
                                    ->integerNode('priority')->isRequired()->end()
                                    ->scalarNode('path')->isRequired()->end()
                                    ->integerNode('tileExpansionIntervalCount')->end()
                                    ->scalarNode('tileExpansionGrowthExpression')->cannotBeEmpty()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end()
        ;

        return $connectorNode->getRootNode();
    }
}
