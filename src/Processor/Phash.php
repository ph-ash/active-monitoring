<?php

declare(strict_types=1);

namespace App\Processor;

use App\Configuration\DTO\MonitoringConfiguration;
use App\Evaluation\Result;

interface Phash
{
    public function updateMonitoring(Result $evaluationResult, MonitoringConfiguration $monitoringConfiguration): void;
}
