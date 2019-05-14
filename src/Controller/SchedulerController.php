<?php

declare(strict_types=1);

namespace App\Controller;

use App\Configuration\Load;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SchedulerController extends AbstractController
{
    /**
     * @Route("/schedule", name="schedule")
     */
    public function scheduleAction(Load $load)
    {
        $config = $load->load();

        // TODO
        //foreach ($config as ) {
        //
        //}
        //$cron = CronExpression::factory('* * * * *');

        return new JsonResponse($config);
    }
}
