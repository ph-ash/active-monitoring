<?php

declare(strict_types=1);

namespace App\Connector;

use App\Configuration\DTO\MonitoringConfiguration;
use Exception;

interface Monitoring
{
    /**
     * @throws Exception
     */
    public function execute(MonitoringConfiguration $configuration): array;
}
