<?php

declare(strict_types=1);

namespace App\Processor;

use App\Configuration\DTO\MonitoringConfiguration;
use App\Evaluation\Result;
use DateTimeImmutable;
use Phash\Client;
use Phash\MonitoringData;

class PhashService implements Phash
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function updateMonitoring(
        string $monitoringId,
        Result $evaluationResult,
        MonitoringConfiguration $monitoringConfiguration,
        array $pluginResult
    ): void {
        $monitoringData = new MonitoringData(
            $monitoringId,
            $evaluationResult->isMonitoringRed() ? MonitoringData::STATUS_ERROR : MonitoringData::STATUS_OK,
            $this->replacePlaceholders($monitoringConfiguration, $pluginResult),
            $monitoringConfiguration->getOptions()->getIdleTimeoutInSeconds(),
            $monitoringConfiguration->getOptions()->getPriority(),
            new DateTimeImmutable(),
            $monitoringConfiguration->getOptions()->getPath()
        );
        if ($monitoringConfiguration->getOptions()->getTileExpansionIntervalCount()) {
            $monitoringData->setTileExpansionIntervalCount($monitoringConfiguration->getOptions()->getTileExpansionIntervalCount());
        }
        if ($monitoringConfiguration->getOptions()->getTileExpansionGrowthExpression()) {
            $monitoringData->setTileExpansionGrowthExpression($monitoringConfiguration->getOptions()->getTileExpansionGrowthExpression());
        }

        $this->client->push($monitoringData);
    }

    private function replacePlaceholders(MonitoringConfiguration $monitoringConfiguration, array $pluginResult): string
    {
        return str_replace(
            array_map(static function (string $key) { return '{' . $key . '}'; }, array_keys($pluginResult)),
            $pluginResult,
            $monitoringConfiguration->getOptions()->getPayload()
        );
    }
}
