<?php

declare(strict_types=1);

namespace App\Connector\MySQL;

use App\Configuration\DTO\MonitoringConfiguration;
use App\Plugin\Plugin as PluginInterface;

class Plugin implements PluginInterface
{
    public function execute(MonitoringConfiguration $configuration): array
    {
        // TODO
        return [];
    }
}
