<?php

declare(strict_types=1);

namespace App\Connector;

use App\Configuration\DTO\MonitoringConfiguration;

interface Monitoring
{
    public function execute(MonitoringConfiguration $configuration): array;
}
