<?php

declare(strict_types=1);

namespace App\Connector\Mysql;

use App\Configuration\DTO\MonitoringConfiguration;
use App\Plugin\Plugin;
use stdClass;

class MysqlPlugin implements Plugin
{
    public function execute(MonitoringConfiguration $configuration): stdClass
    {
        return new stdClass();
    }
}
