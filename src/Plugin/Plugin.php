<?php

declare(strict_types=1);

namespace App\Plugin;

use App\Configuration\DTO\MonitoringConfiguration;
use stdClass;

interface Plugin
{
    public function execute(MonitoringConfiguration $configuration): stdClass;
}
