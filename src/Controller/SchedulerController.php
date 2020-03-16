<?php

declare(strict_types=1);

namespace App\Controller;

use App\Configuration\Load;
use App\Processor\ScheduleProcessor;
use Cron\CronExpression;
use Enqueue\Client\Message;
use Enqueue\Client\ProducerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class SchedulerController extends AbstractController
{
    /**
     * @Route("/schedule", name="schedule")
     */
    public function scheduleAction(Load $load, ProducerInterface $producer, SerializerInterface $serializer)
    {
        try {
            $config = $load->load();
        } catch (Exception $exception) {
            return new Response(sprintf('error: %s', $exception->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $scheduled = 0;

        foreach ($config['active_monitoring'] as $connectorName => $connector) {
            foreach ($connector['monitorings'] as $monitoringKey => $monitoring) {
                $cron = CronExpression::factory($monitoring['options']['cron']);
                if ($cron->isDue()) {
                    $payload = $serializer->serialize($monitoring, JsonEncoder::FORMAT);
                    $producer->sendEvent(
                        'schedule',
                        new Message(
                            $payload,
                            [
                                ScheduleProcessor::MONITORING_KEY => $monitoringKey,
                                ScheduleProcessor::CONNECTOR_NAME => $connectorName
                            ]
                        )
                    );
                    $scheduled++;
                }
            }
        }

        return new Response(sprintf('success: %d monitorings scheduled', $scheduled));
    }
}
