<?php

declare(strict_types=1);

namespace App\Configuration\DTO;

class Options
{
    private $cron;
    private $failureConditions;
    private $payload;
    private $idleTimeoutInSeconds;
    private $priority;
    private $path;
    private $tileExpansionIntervalCount;
    private $tileExpansionGrowthExpression;

    public function __construct(
        string $cron,
        array $failureConditions,
        string $payload,
        int $idleTimeoutInSeconds,
        int $priority,
        ?string $path,
        int $tileExpansionIntervalCount = null,
        string $tileExpansionGrowthExpression = null
    ) {
        $this->cron = $cron;
        $this->failureConditions = $failureConditions;
        $this->payload = $payload;
        $this->idleTimeoutInSeconds = $idleTimeoutInSeconds;
        $this->priority = $priority;
        $this->path = $path;
        $this->tileExpansionIntervalCount = $tileExpansionIntervalCount;
        $this->tileExpansionGrowthExpression = $tileExpansionGrowthExpression;
    }

    public function getCron(): string
    {
        return $this->cron;
    }

    public function getFailureConditions(): array
    {
        return $this->failureConditions;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getIdleTimeoutInSeconds(): int
    {
        return $this->idleTimeoutInSeconds;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getTileExpansionIntervalCount(): ?int
    {
        return $this->tileExpansionIntervalCount;
    }

    public function getTileExpansionGrowthExpression(): ?string
    {
        return $this->tileExpansionGrowthExpression;
    }
}
