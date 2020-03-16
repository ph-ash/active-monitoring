<?php

declare(strict_types=1);

namespace App\Processor;

use App\Configuration\DTO\MonitoringConfiguration;
use App\Evaluation\Result;
use Exception;

interface Phash
{
    /**
     * @param string $monitoringId
     * @param Result $evaluationResult
     * @param MonitoringConfiguration $monitoringConfiguration
     * @param array $pluginResult
     * @throws Exception
     */
    public function updateMonitoring(
        string $monitoringId,
        Result $evaluationResult,
        MonitoringConfiguration $monitoringConfiguration,
        array $pluginResult
    ): void;
}
