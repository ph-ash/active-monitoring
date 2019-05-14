<?php

declare(strict_types=1);

namespace App\Controller;

use App\Configuration\Load;
use Cron\CronExpression;
use Enqueue\Client\Message;
use Enqueue\Client\ProducerInterface;
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
        $config = $load->load();
        $scheduled = 0;

        foreach ($config['active_monitoring'] as $connector) {
            foreach ($connector['monitorings'] as $monitoringKey => $monitoring) {
                $cron = CronExpression::factory($monitoring['options']['cron']);
                if ($cron->isDue()) {
                    $payload = $serializer->serialize($monitoring, JsonEncoder::FORMAT);
                    $producer->sendEvent('schedule', new Message($payload, ['monitoring.key' => $monitoringKey]));
                    $scheduled++;
                }
            }
        }

        return new Response(sprintf('%d monitorings scheduled', $scheduled));
    }
}
