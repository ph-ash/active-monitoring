<?php

declare(strict_types=1);

namespace App\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

interface ConnectorConfiguration
{
    public function getConnectionConfigurationNode(TreeBuilder $builder): void;

    public function getMonitoringConfigurationNode(TreeBuilder $builder): void;

    public function getConnectorName(): string;
}
