<?php

declare(strict_types=1);

namespace App\Connector\MySQL;

use App\Configuration\DTO\MonitoringConfiguration;
use App\Connector\Monitoring as MonitoringInterface;

class Monitoring implements MonitoringInterface
{
    public function execute(MonitoringConfiguration $configuration): array
    {
        // TODO
        return [];
    }
}
