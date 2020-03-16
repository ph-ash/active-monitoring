<?php

declare(strict_types=1);

namespace App\Controller;

use App\Configuration\DTO\MonitoringConfiguration;
use App\Connector\Monitoring;
use App\Evaluation\Evaluate;
use App\Processor\Phash;
use App\Processor\ScheduleProcessor;
use Exception;
use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ExecuteController extends AbstractController
{
    /**
     * @Route("/execute/{monitoringId}", name="execute", methods={"POST"})
     * @ParamConverter("monitoringConfiguration", class="App\Configuration\DTO\MonitoringConfiguration")
     * @throws Exception
     */
    public function scheduleAction(
        string $monitoringId,
        MonitoringConfiguration $monitoringConfiguration,
        Evaluate $evaluate,
        Phash $phash,
        Request $request,
        iterable $connectorMonitorings
    ) {
        $monitoringId = urldecode($monitoringId);

        $connectorType = $request->headers->get(strtolower(ScheduleProcessor::CONNECTOR_NAME_HEADER));
        if (!$connectorType) {
            throw new NotFoundHttpException(sprintf('monitoring id "%s" is not defined in the configuration file', $monitoringId));
        }

        $monitoringExecutor = $this->findMonitoringExecutor($connectorMonitorings, $connectorType);
        if (!$monitoringExecutor) {
            throw new LogicException(
                sprintf('configuration validated with connector "%s", but no monitoring was tagged', $monitoringExecutor)
            );
        }

        $pluginResult = $monitoringExecutor->execute($monitoringConfiguration);
        $evaluationResult = $evaluate->evaluateConditions($pluginResult, $monitoringConfiguration->getOptions()->getFailureConditions());
        $phash->updateMonitoring($monitoringId, $evaluationResult, $monitoringConfiguration, $pluginResult);

        return new Response(sprintf('executed monitoring id "%s" with connector "%s"', $monitoringId, $connectorType));
    }

    private function findMonitoringExecutor(iterable $connectorMonitorings, string $foundConnectorType): Monitoring
    {
        $foundMonitoring = null;
        $expectedNamespacePrefix = sprintf('App\\Connector\\%s\\', $foundConnectorType);
        foreach ($connectorMonitorings as $connectorMonitoring) {
            if (strncmp(get_class($connectorMonitoring), $expectedNamespacePrefix, strlen($expectedNamespacePrefix)) === 0) {
                $foundMonitoring = $connectorMonitoring;
                break;
            }
        }
        return $foundMonitoring;
    }
}
