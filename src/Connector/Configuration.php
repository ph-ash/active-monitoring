<?php

declare(strict_types=1);

namespace App\Connector;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

interface Configuration
{
    public function getConnectionConfigurationNode(TreeBuilder $builder): void;

    public function getMonitoringConfigurationNode(TreeBuilder $builder): void;
}
