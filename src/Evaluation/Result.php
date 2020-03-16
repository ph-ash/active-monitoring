<?php

declare(strict_types=1);

namespace App\Evaluation;

class Result
{
    private $monitoringRed;
    private $details;

    public function __construct(bool $monitoringRed, array $details)
    {
        $this->monitoringRed = $monitoringRed;
        $this->details = $details;
    }

    public function isMonitoringRed(): bool
    {
        return $this->monitoringRed;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}
